<?php

namespace App\Http\Controllers\Auth;

use App\Common\CommonFunction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\User\AuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Display the password reset link request view.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.auth.forgot_password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->authService->forgotPassword($request);
        if ($result['error']) {
            throw ValidationException::withMessages(['email' => [$result['status']]]);
        }

        return CommonFunction::responseSuccessMessageJsonData($result['status']);
    }

    /**
     * Display the password reset link request view.
     *
     * @return View
     */
    public function forgotPasswordPage(): View
    {
        return view('admin.auth.forgot_password');
    }
}
