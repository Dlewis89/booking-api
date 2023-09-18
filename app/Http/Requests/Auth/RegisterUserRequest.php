<?php

namespace App\Http\Requests\Auth;

use App\Utils\Util;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email:rfc,dns|required|unique:users',
            'password' => ['string','required','confirmed',Password::defaults()],
        ];
    }
}
