<?php

namespace App\Services;

use App\Common\BioStarConstant;
use App\Common\CodeMaster;
use App\Common\Constant;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\Admin\BioStar2LinkFailure;
use App\Mail\PasswordUpdate;
use App\Models\PasswordReset;
use App\Repositories\FileManagement\FileManagementRepository;
use App\Repositories\IndividualUser\IndividualUserRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\UserExtend\UserExtendRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class BaseAuthService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        protected UserRepository $userRepository,
    )
    {
    }

    /**
     * Register a Admin.
     *
     * @param array $requestData
     * @return array
     */
    public function register(array $requestData): array
    {
        $this->userRepository->create([
            'name'     => $requestData['name'],
            'email'    => $requestData['email'],
            'password' => Hash::make(Str::random(10)),
        ]);

        $status = $this->handleSendResetLink(
            $requestData['email'],
            function ($admin, $token) {
                // TODO: handle email template for register a new admin via reuse reset password template
                $admin->sendPasswordResetNotification($token);
            }
        );
        if ($status == Password::RESET_LINK_SENT) {
            return ['error' => false, 'status' => __($status)];
        }

        return ['error' => true, 'status' => trans($status)];
    }

    /**
     * Handle send reset link
     *
     * @param string $email
     * @param Closure|null $callback
     * @return string
     */
    private function handleSendResetLink(string $email, Closure $callback = null): string
    {
        return Password::sendResetLink(['email' => $email], $callback);
    }

    /**
     * Handle logout a admin
     *
     * @return array
     */
    public function logout(): array
    {
        auth(getApiGuard())->logout();

        return generateSuccessMessage(__('auth.logout.success'));
    }

    /**
     * Get current user info
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function me()
    {
        return auth(getApiGuard())->user();
    }

    /**
     * Handle forgot password for admin
     *
     * @param ForgotPasswordRequest $request
     * @return array
     */
    public function forgotPassword(ForgotPasswordRequest $request): array
    {
        $email = $request->email;
        $user  = $this->getUser($email);
        if (is_null($user)) {
            return ['error' => true, 'status' => __('passwords.user')];
        }

        $passwordResetRepository = Password::getRepository();
        $token                   = $passwordResetRepository->createNewToken();
        PasswordReset::insert(['email' => $email, 'token' => Hash::make($token), 'created_at' => Carbon::now()]);
        $user->sendPasswordResetNotification($token);

        return ['error' => false, 'status' => __('messages.AMSG.00038')];
    }

    /**
     * Get user by email
     *
     * @param string $email
     * @return CanResetPassword|null
     */
    private function getUser(string $email): ?CanResetPassword
    {
        return Password::getUser(['email' => $email, 'status' => Constant::ACTIVE]);
    }

    /**
     * Handle reset password for admin
     *
     * @param ResetPasswordRequest $request
     * @return array
     * @throws \JsonException
     */
    public function resetPassword(ResetPasswordRequest $request): array
    {
        $email = $request->email;
        $user  = $this->getUser($email);
        if (is_null($user)) {
            return generateErrorMessage(__('messages.AMSG.00056'));
        }
        // check new user register password or old user forgot password
        $newAccount = $user->password === null;

        $data = PasswordReset::where('email', $email)->latest()->get();
        if ($data->isEmpty()) {
            if (str_contains(request()->getPathInfo(), Constant::BASE_PATH_PREFIX)) {
                return generateErrorMessage(__('messages.AMSG.00057'));
            }
            return generateErrorMessage(__('messages.AMSG.00056'));
        }

        $isTokenValid = false;
        $token        = $request->token;
        $expires      = config('auth.passwords.users.expire') * Constant::SIXTY_SECONDS;
        foreach ($data as $item) {
            if ($this->checkTokenExpired($item->created_at->toDateTimeString(), $expires)) {
                continue;
            }
            if (Hash::check($token, $item->token)) {
                $isTokenValid = true;
                break;
            }
        }
        if (!$isTokenValid) {
            return generateErrorMessage(__('messages.AMSG.00039'));
        }

        $user->forceFill(['password' => Hash::make($request->password)])->save();
        $fullName = $user->last_name . ' ' . $user->first_name;
        Password::deleteToken($user);
        Mail::to($email)->send(new PasswordUpdate($fullName, $user->role_id));

        if ($newAccount && ($user->role_id === Constant::NORMAL_USER_ROLE_ID
                || $user->role_id === Constant::NORMAL_USER_ROLE_ID)) {
        }

        return generateSuccessMessage(__('messages.AMSG.00013', ['attribute' => __('common.password')]));
    }

    /**
     * Check token expired
     *
     * @param string $createdAt
     * @param int $expires
     * @return bool
     */
    private function checkTokenExpired(string $createdAt, int $expires): bool
    {
        return Carbon::parse($createdAt)->addSeconds($expires)->isPast();
    }
}
