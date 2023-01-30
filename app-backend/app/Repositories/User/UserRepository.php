<?php

namespace App\Repositories\User;

use App\Models\IndividualUser;
use App\Models\User;
use App\Models\UserCompanyExtend;
use App\Models\UserExtend;
use App\Repositories\EloquentRepository;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use App\Common\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Common\CommonFunction;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;
use App\Common\CodeMaster;
use Illuminate\Support\Facades\DB;
use App\Mail\PasswordUpdate;
use Illuminate\Support\Facades\Mail;

class UserRepository extends EloquentRepository implements UserInterface
{
    /**
     * Get model
     *
     * @return string
     */
    public function getModel(): string
    {
        return User::class;
    }

    /**
     * Get query builder with conditions
     *
     * @param array $requestData
     * @return Builder
     */
    protected function handleConditionsForAjax(array $requestData): Builder
    {
        $search = $requestData['search'] ?? '';
        $filter = $requestData['filter'] ?? []; // We can use this variable for 'where' conditions in future

        return $this->_model
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            });
    }

    /**
     * Get query system admin
     *
     * @param Request $request
     * @return Paginator
     */
    public function searchSystemUser($request): Paginator
    {
        $filter = $request->has('filter') ? $request['filter'] : [];
        $perPage = $request->has('perPage') ? $request['perPage'] : Constant::DEFAULT_PER_PAGE;
        $page = $request->has('page') ? $request['page'] : Constant::DEFAULT_PAGE;
        $roleId = $request->has('roleId') ? $request['roleId'] : Constant::SUPER_ADMIN_ROLE_ID;
        $result = [];
        try {
            $result = $this->_model
                ->where('role_id', '=', $roleId)
                ->when(!empty($filter['userName']), function ($query) use ($filter) {
                    return $query->where(function ($q) use ($filter) {
                        return $q->orWhere('first_name', 'like', '%' . $filter['userName'] . '%')
                            ->orWhere('last_name', 'like', '%' . $filter['userName'] . '%')
                            ->orWhereRaw("trim(concat(last_name, ' ', first_name)) = ?", [$filter['userName']]);
                    });
                })
                ->when(!empty($filter['email']), function ($query) use ($filter) {
                    return $query->where('email', 'like', '%' . $filter['email'] . '%');
                })
                ->when(isset($filter['status']), function ($query) use ($filter) {
                    return $query->where('status', '=', $filter['status']);
                })
                ->paginate($perPage, ['*'], 'page', $page);
        } catch (Exception $e) {
            logs()->error('UserRepository searchSystemUser errors: ', [$e->getFile(), $e->getLine(), $e->getMessage()]);
        }
        return $result;
    }

    /**
     * Create a new system user
     *
     * @param array $request
     * @return bool
     */
    public function createSystemAdmin(array $request): bool
    {
        DB::beginTransaction();
        try {
            $this->createUser($request);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            logs()->error('UserRepository create errors: ', [$e->getFile(), $e->getLine(), $e->getMessage()]);
            return false;
        }
        return true;
    }


    /**
     * Create a new user
     *
     * @param array $request
     * @return mixed
     */
    public function createUser(array $request): mixed
    {
        DB::beginTransaction();
        try {
            // create data for User model
            $userData = array_merge($request, [
                'role_id' => Constant::NORMAL_USER_ROLE_ID, 'password' => Hash::make($request['password'])
            ]);
            $user = $this->updateOrCreate([['email', $request['email']], ['deleted_at']], $userData);
            $user->role_id = Constant::NORMAL_USER_ROLE_ID;
            $user->password = Hash::make($request['password']);
            $user->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            logs()->error('UserRepository create errors: ', [$e->getFile(), $e->getLine(), $e->getMessage()]);
            return false;
        }
        return $user;
    }

    /**
     * Update a user
     * @param array $request
     * @param $id
     * @return bool
     */
    public function updateUser(array $request, $id): bool
    {
        DB::beginTransaction();
        try {
            $dataUpdate = CommonFunction::convertArrayKeyToSnakeCase($request);
            // update data for user system admin
            if (!$this->_model->find($id)?->fill($dataUpdate)->save()) {
                throw new RuntimeException('UserRepository update Model errors');
            }
            // reset password
            if (isset($request['newPassword'])) {
                $user = $this->_model->find($id);
                $user->password = Hash::make($request['newPassword']);
                $user->save();
                Mail::to($user->email)->send(new PasswordUpdate($user->full_name, $user->role_id));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            logs()->error('UserRepository update errors: ', [$e->getFile(), $e->getLine(), $e->getMessage()]);
            return false;
        }
        return true;
    }

}
