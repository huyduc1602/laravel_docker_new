<?php

namespace App\Http\Controllers\User;

use App\Common\CommonFunction;
use App\Http\Controllers\Auth\BaseAuthenticatedSessionController;
use App\Http\Requests\Auth\SendMailRegisterRequest;
use App\Http\Requests\Auth\SendVerifyOTPRequest;
use App\Http\Requests\Auth\VerifyInputOTPRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\IndividualUserInformationRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\User\AuthService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends BaseAuthenticatedSessionController
{
    public function __construct(AuthService $authService)
    {
        parent::__construct($authService);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request);

        return CommonFunction::responseJsonData($result);
    }

    /**
     * Get the authenticated admin.
     *
     * @return UserResource
     */
    public function me(): UserResource
    {
        $result = $this->authService->me();

        return new UserResource($result);
    }

    /**
     * Register send mail
     *
     * @param SendMailRegisterRequest $request
     * @return JsonResponse
     */
    public function sendMailRegister(SendMailRegisterRequest $request): JsonResponse
    {
        return CommonFunction::responseMessageJsonData($this->authService->sendMailRegister($request->all()));
    }

    /**
     *
     * Check valid url register
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyRegistrationLink(Request $request): JsonResponse
    {
        return CommonFunction::responseJsonData($this->authService->verifyRegistrationLink($request->all()));
    }

    /**
     * Register new user
     *
     * @param User $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function register(User $request): JsonResponse
    {
        return CommonFunction::responseMessageJsonData($this->authService->store($request->all()));
    }
}
