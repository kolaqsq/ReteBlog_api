<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function rules()
    {
        return [
            'file' => ['required', 'image', 'max:10240'],
            'path' => ['string'],
            'disk' => ['string'],
        ];
    }
}
