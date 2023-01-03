<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\EloquentRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Common\CommonFunction;
use RuntimeException;
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
     * @param array $request
     * @return mixed
     */
    public function createUser(array $request): User
    {
        $dataSave = CommonFunction::convertArrayKeyToSnakeCase($request);
        // create data for User model
        $user = $this->_model->newInstance();
        $user->fill($dataSave);
        $user->save();
        return $user;
    }

    /**
     * Update a user system admin
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
            if ($this->_model->find($id)?->fill($dataUpdate)->save()) {
                $user = new User();
                if (!$user::find($id)?->fill($dataUpdate)->save()) {
                    throw new RuntimeException('UserRepository update UserCompanyExtends Model errors');
                }
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
