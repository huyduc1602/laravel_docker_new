<?php

namespace App\Http\Controllers\User;

use App\Common\CommonFunction;
use App\Http\Controllers\Auth\BaseAuthenticatedSessionController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UserInformationRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\AuthService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
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
     * Register new user
     *
     * @param UserInformationRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function register(UserInformationRequest $request): JsonResponse
    {
        return CommonFunction::responseMessageJsonData($this->authService->store($request->all()));
    }
}
