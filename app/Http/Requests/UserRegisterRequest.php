<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UserRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['email', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'min:12', 'max:12', 'regex:/^[+]3706[0-9]{7}$/', 'unique:users'],
            'terms' => ['required', 'boolean', 'accepted'],
        ];
    }
}
