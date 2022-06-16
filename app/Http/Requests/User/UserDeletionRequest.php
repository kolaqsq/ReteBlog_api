<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserDeletionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => ['required'],
        ];
    }
}
