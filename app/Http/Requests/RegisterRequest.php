<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $email
 * @property string $password
 * @property string $password_confirmation
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['string', 'max:255', 'unique:users,username', 'regex:/^[\w-]+$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ];
    }
}
