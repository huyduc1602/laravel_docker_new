<?php

namespace App\Http\Requests\User;

use App\Common\CodeMaster;
use App\Common\Constant;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user = auth(getApiGuard())->user();
        return [
            'lastName'                => 'required|string|max:' . Constant::VALIDATION_RULE['maxLength32'],
            'firstName'               => 'required|string|max:' . Constant::VALIDATION_RULE['maxLength32'],
            'birthday'                => [
                'nullable',
                'bail',
                'digits:' . Constant::VALIDATION_RULE['digits4'],
                'numeric',
                'between:' . Carbon::now()->subYears(Constant::BETWEEN_NUMBER['80'])->year
                . ',' . Carbon::now()->subYears(Constant::BETWEEN_NUMBER['18'])->year
            ],
            'email'                   => [
                'required',
                'regex:' . Constant::VALIDATION_RULE['emailAlphabetSymbol'],
                'email',
                Rule::unique('users', 'email')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($user->id, 'id'),
                'string',
                'max:' . Constant::VALIDATION_RULE['maxLength175'],
            ],
            'oldPassword'             => ['sometimes', 'required', 'match_old_password'],
            'newPassword'             => [
                'sometimes',
                'required',
                'regex:' . Constant::VALIDATION_RULE['password']
            ],
            'newPasswordConfirmation' => [
                'required_with:newPassword',
                'same:newPassword'
            ],
            'gender'                  => [
                'nullable',
                Rule::exists('s_code', 'code')
                    ->where('category', CodeMaster::CATEGORY_D1004)
                    ->whereNull('deleted_at')
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
            'lastName.required'                     => __('messages.VMSG.00001'),
            'lastName.max'                          => __('messages.VMSG.00016'),
            'firstName.required'                    => __('messages.VMSG.00001'),
            'firstName.max'                         => __('messages.VMSG.00016'),
            'birthday.digits'                       => __('messages.VMSG.00110',
                ['{1}' => Constant::VALIDATION_RULE['digits4']]),
            'birthday.between'                      => __('messages.VMSG.00075', [
                'min' => Carbon::now()->subYears(Constant::BETWEEN_NUMBER['80'])->year,
                'max' => Carbon::now()->subYears(Constant::BETWEEN_NUMBER['18'])->year,
            ]),
            'email.required'                        => __('messages.VMSG.00001'),
            'email.regex'                           => __('messages.VMSG.00028'),
            'email.email'                           => __('messages.VMSG.00099'),
            'email.max'                             => __('messages.VMSG.00016'),
            'email.unique'                          => __('messages.AMSG.00020'),
            'oldPassword.required'                  => __('messages.VMSG.00001'),
            'oldPassword.match_old_password'        => __('messages.AMSG.00113'),
            'newPassword.required'                  => __('messages.VMSG.00001'),
            'newPassword.regex'                     => __('messages.VMSG.00103'),
            'newPasswordConfirmation.required_with' => __('messages.VMSG.00001'),
            'newPasswordConfirmation.same'          => __('messages.VMSG.00104'),
            'gender.exists'                         => __('messages.VMSG.00068'),
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
            'lastName'                => __('common.attributes.lastName'),
            'firstName'               => __('common.attributes.firstName'),
            'email'                   => __('common.attributes.email'),
            'birthday'                => __('common.attributes.birthday'),
            'oldPassword'             => __('common.attributes.oldPassword'),
            'newPassword'             => __('common.attributes.newPassword'),
            'newPasswordConfirmation' => __('common.attributes.newPasswordConfirmation'),
            'gender'                  => __('common.attributes.gender'),
        ];
    }
}
