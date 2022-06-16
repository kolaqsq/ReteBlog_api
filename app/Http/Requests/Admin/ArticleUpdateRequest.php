<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
//            'slug' => ['nullable', 'string', 'unique:articles,slug'],
            'content' => ['required', 'string'],
            'file' => ['image', 'max:10240'],
            'path' => ['string'],
            'disk' => ['string'],
        ];
    }
}
