<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ArticleCreateRequest;

class ArticleController extends Controller
{
    public function store(ArticleCreateRequest $request)
    {
        $data = array_merge($request->validated(), [
            'user' => $request->user(),
        ]);


    }
}
