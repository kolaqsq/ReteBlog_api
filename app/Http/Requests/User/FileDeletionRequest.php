<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class FileDeletionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'filename' => ['required', 'string'],
        ];
    }
}
