<?php

use App\Common\CommonFunction;
use App\Common\Constant;
use App\Http\Resources\User\UserResource;
use App\Rules\User\ValidateUserEmail;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'               => ['bail', 'required', 'string', 'email', new ValidateUserEmail],
            'password'            => ['required', 'string'],
            'acceptTermOfService' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return array
     * @throws ValidationException
     */
    public function authenticate(): array
    {
        $rateLimited = $this->ensureIsNotRateLimited();
        if ($rateLimited['errors']) {
            return generateErrorMessage($rateLimited['message'], Constant::HTTP_STATUS_FORBIDDEN);
        }

        $credentials = $this->only('email', 'password') + [
                'status'  => Constant::ACTIVE,
                'role_id' => Constant::NORMAL_USER_ROLE_ID
            ];
        $authenticate = Auth::guard(getApiGuard())->attempt($credentials);
        if (!$authenticate) {
            RateLimiter::hit($this->throttleKey(), Constant::FIVE_MINUTES_TO_SECOND);

            throw ValidationException::withMessages(['email' => [__('messages.AMSG.00001')]]);
        }

        RateLimiter::clear($this->throttleKey());
        $data = $this->generateInfoData($authenticate);

        return generateSuccessData($data);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return array
     */
    public function ensureIsNotRateLimited(): array
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return generateSuccessMessage();
        }

        event(new Lockout($this));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        return generateErrorMessage(__('messages.AMSG.00037', [
            'seconds' => $seconds,
            'minutes' => Constant::FIVE_MINUTES,
        ]));
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }

    /**
     * Generate info data
     *
     * @param string $authenticate
     * @return array
     */
    private function generateInfoData(string $authenticate): array
    {
        $user = auth(getApiGuard())->user();
        $info = (new UserResource($user))->toArray(request());

        return ['info' => $info] + CommonFunction::generateTokenData($authenticate);
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $error = $validator->messages()->first('email') === __('messages.AMSG.00040');
        if ($error) {
            throw new HttpResponseException(
                response()->json(['errors' => true, 'message' => __('messages.AMSG.00040')], Constant::HTTP_STATUS_FORBIDDEN)
            );
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
