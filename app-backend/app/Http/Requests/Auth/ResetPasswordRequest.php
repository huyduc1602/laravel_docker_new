<?php

namespace App\Http\Requests\Auth;

use App\Common\Constant;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'token'                => 'required',
            'email'                => 'required|email',
            'password'             => ['required', 'same:passwordConfirmation', 'regex:' . Constant::VALIDATION_RULE['password']],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return ['password.regex' => __('messages.VMSG.00103'),];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return ['password' => __('common.attributes.newPassword')];
    }
}
