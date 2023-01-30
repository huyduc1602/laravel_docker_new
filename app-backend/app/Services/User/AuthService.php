<?php

namespace App\Services\User;

use App\Common\CommonFunction;
use App\Common\Constant;
use App\Services\BaseAuthService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use LoginRequest;

class AuthService extends BaseAuthService
{
    /**
     * Handle login a user
     *
     * @param LoginRequest $request
     * @return array
     * @throws ValidationException
     */
    public function login(LoginRequest $request): array
    {
        $data = $request->authenticate();

        if (!empty($data['errors'])) {
            return $data;
        }

        $user = $data['data']['info'];

        if ($user['roleId'] === Constant::NORMAL_USER_ROLE_ID) {
            $user = $this->userRepository->findWhere(['user_id' => $user['id']]);

            if (!$user) {
                throw ValidationException::withMessages(['email' => [__('messages.AMSG.00001')]]);
            }
        }

        return $data;
    }

    public function register(array $request) : array
    {
        DB::beginTransaction();
        try {
            if (!is_null($this->userRepository->findWhere(['email' => $request['email']]))) {
                return generateErrorMessage(__('messages.AMSG.00020', [
                    'attribute' => __('common.attributes.email')
                ]));
            }
            $dataSave = CommonFunction::convertArrayKeyToSnakeCase($request);
            $user = $this->userRepository->createUser($dataSave);

            if (!$user) {
                DB::rollBack();
                return generateErrorMessage(__('messages.AMSG.00054'), Constant::HTTP_STATUS_BAD_REQUEST);
            }
        } catch (Exception $e) {
            logs()->error($e);
            DB::rollBack();
            return generateErrorMessage(__('messages.AMSG.00054'), Constant::HTTP_STATUS_CONFLICT);
        }
        DB::commit();
        return generateSuccessMessage(__('messages.AMSG.00016', [
            'attribute' => __('common.attributes.user')
        ]));
    }
}
