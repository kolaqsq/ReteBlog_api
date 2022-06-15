<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string username
 * @property string $email
 * @property string $password
 * @property string $password_confirmation
 */
class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . auth()->user()->id,
                'regex:/^[\w-]+$/'
            ],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->user()->id],
            'password' => ['confirmed'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ];
    }
}
