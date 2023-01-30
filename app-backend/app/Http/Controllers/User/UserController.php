<?php

namespace App\Http\Controllers\User;

use App\Common\CommonFunction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ConfirmPasswordRequest;
use App\Http\Requests\User\IndividualUserInformationRequest;
use App\Http\Requests\User\CreditCardRegisterRequest;
use App\Http\Requests\User\UserInformationRequest;
use App\Http\Resources\User\CardCreditCollection;
use App\Http\Resources\User\UserResource;
use App\Services\User\BookingService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        private UserService    $userService,
    )
    {
    }

    /**
     * Get personal user login information
     *
     * @return JsonResponse|UserResource
     */
    public function edit(): UserResource|JsonResponse
    {
        $user = $this->userService->edit();
        if (empty($user)) {
            return CommonFunction::responseMessageJsonData(generateErrorMessage(__('messages.AMSG.00002')));
        }
        return new UserResource($user);
    }

    /**
     * Update user login information
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function update(UserRequest $request): JsonResponse
    {
        return CommonFunction::responseMessageJsonData($this->userService->updatePersonalUser($request->all()));
    }

    /**
     * Confirm password of the user
     *
     * @param ConfirmPasswordRequest $request
     * @return JsonResponse
     */
    public function confirmPassword(ConfirmPasswordRequest $request): JsonResponse
    {
        return CommonFunction::responseMessageJsonData($this->userService->confirmPassword());
    }

}
