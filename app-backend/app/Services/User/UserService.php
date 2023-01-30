<?php

namespace App\Services\User;

use App\Common\Constant;
use App\Repositories\User\UserRepository;
use App\Services\User\AuthService;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        private UserRepository                  $userRepository,
    )
    {
    }

    /**
     * Get single system user
     *
     * @return mixed
     */
    public function edit(): mixed
    {
        $user = auth(getApiGuard())->user();
        return $this->userRepository->find($user->id);
    }


    /**
     * Update personal user information
     *
     * @param array $request
     * @return array
     */
    public function updatePersonalUser(array $request): array
    {
        $user = auth(getApiGuard())->user();
        DB::beginTransaction();
        try {
            unset($request['email']);
            if (!$this->userRepository->updateUser($request, $user->id)) {
                return generateErrorMessage(__('messages.AMSG.00054', Constant::HTTP_STATUS_BAD_REQUEST));
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return generateErrorMessage(__('messages.AMSG.00054'), Constant::HTTP_STATUS_CONFLICT);
        }

        if (isset($request['newPassword'])) {
            auth(getApiGuard())->logout();
        }

        return generateSuccessMessage(__('messages.AMSG.00013', [
            'attribute' =>  __('common.attributes.personal')
        ]));
    }

    /**
     * Confirm password of the user
     *
     * @return array
     */
    public function confirmPassword(): array
    {
        // Todo: update message code when has design document
        return generateSuccessMessage('Match current password');
    }

}
