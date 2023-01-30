<?php

namespace App\Http\Requests;

use App\Rules\HalfWidth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required','alpha_num','max:255', new HalfWidth],
            'password' => ['required','between:8,32','alpha_num', new HalfWidth],
        ];
    }
}
