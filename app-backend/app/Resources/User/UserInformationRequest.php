<?php

namespace App\Http\Requests\User;

use App\Common\CodeMaster;
use App\Common\Constant;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserInformationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $user = auth(getApiGuard())->user();
        return [
            'email'               => [
                'required',
                'regex:' . Constant::VALIDATION_RULE['emailAlphabetSymbol'],
                'bail',
                Rule::unique('users', 'email')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($user?->id),
                'string',
                'email',
                'max:' . Constant::VALIDATION_RULE['maxLength175'],
            ],
            'phoneNumber'         => [
                'required',
                'bail',
                'regex:' . Constant::VALIDATION_RULE['onlyNumber'],
                'digits:' . Constant::VALIDATION_RULE['digits11']
            ],
            'firstName'           => 'required|string|max:' . Constant::VALIDATION_RULE['maxLength24'],
            'lastName'            => 'required|string|max:' . Constant::VALIDATION_RULE['maxLength24'],
            'birthday'            => [
                'required',
                'bail',
                'digits:' . Constant::VALIDATION_RULE['digits4'],
                'numeric',
                'between:' . Carbon::now()->subYears(Constant::BETWEEN_NUMBER['80'])->year
                . ',' . Carbon::now()->subYears(Constant::BETWEEN_NUMBER['18'])->year
            ],
            'gender'              => [
                'nullable',
                Rule::exists('s_code', 'code')
                    ->where('category', CodeMaster::CATEGORY_D1004)
                    ->whereNull('deleted_at'),
            ],
               'password'            => [
                'sometimes',
                'required',
                'regex:' . Constant::VALIDATION_RULE['password']
            ],
            'oldPassword'         => ['sometimes', 'required', 'match_old_password'],
            'newPassword'         => [
                'sometimes',
                'required',
                'regex:' . Constant::VALIDATION_RULE['password']
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required'                 => __('messages.VMSG.00001'),
            'email.email'                    => __('messages.VMSG.00099'),
            'email.regex'                    => __('messages.VMSG.00028'),
            'email.unique'                   => __('messages.AMSG.00020'),
            'email.max'                      => __('messages.VMSG.00016'),
            'phoneNumber.required'           => __('messages.VMSG.00001'),
            'phoneNumber.regex'              => __('messages.VMSG.00023'),
            'phoneNumber.digits'             => __('messages.VMSG.00110', [
                '{1}' => Constant::VALIDATION_RULE['digits11']
            ]),
            'firstName.required'             => __('messages.VMSG.00001'),
            'firstName.max'                  => __('messages.VMSG.00016'),
            'lastName.required'              => __('messages.VMSG.00001'),
            'lastName.max'                   => __('messages.VMSG.00016'),
            'birthday.required'              => __('messages.VMSG.00001'),
            'birthday.digits'                => __('messages.VMSG.00110',
                ['{1}' => Constant::VALIDATION_RULE['digits4']]),
            'birthday.between'               => __('messages.VMSG.00075', [
                'min' => Carbon::now()->subYears(Constant::BETWEEN_NUMBER['80'])->year,
                'max' => Carbon::now()->subYears(Constant::BETWEEN_NUMBER['18'])->year,
            ]),
            'gender.exists'                  => __('messages.VMSG.00068'),
            'password.required'              => __('messages.VMSG.00001'),
            'password.regex'                 => __('messages.VMSG.00120'),
            'oldPassword.required'           => __('messages.VMSG.00001'),
            'oldPassword.match_old_password' => __('messages.AMSG.00113'),
            'newPassword.required'           => __('messages.VMSG.00001'),
            'newPassword.regex'              => __('messages.VMSG.00120'),

        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'email'               => __('common.attributes.email'),
            'phoneNumber'         => __('common.attributes.mobilePhoneNumber'),
            'firstName'           => __('common.attributes.firstName'),
            'lastName'            => __('common.attributes.lastName'),
            'birthday'            => __('common.attributes.birthday'),
            'gender'              => __('common.attributes.gender'),
            'password'            => __('common.attributes.password'),
            'acceptTermOfService' => __('common.attributes.acceptTermOfService'),
            'oldPassword'         => __('common.attributes.oldPassword'),
            'newPassword'         => __('common.attributes.newPassword'),
        ];
    }
}


