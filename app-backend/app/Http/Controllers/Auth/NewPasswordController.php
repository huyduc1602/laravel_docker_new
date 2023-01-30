<?php

namespace App\Http\Controllers\Auth;

use App\Common\CommonFunction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Admin\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(private AuthService $authService)
    {
    }

    /**
     * Handle an incoming new password request.
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws \JsonException
     */
    public function store(ResetPasswordRequest $request): JsonResponse
    {
        $result = $this->authService->resetPassword($request);
        if ($result['errors']) {
            throw ValidationException::withMessages(['email' => [$result['message']]]);
        }

        return CommonFunction::responseSuccessMessageJsonData($result['message']);
    }
}
