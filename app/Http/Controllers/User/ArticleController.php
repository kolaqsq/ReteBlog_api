<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Managers\ArticleManager;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    private ArticleManager $articleManager;

    public function __construct()
    {
        $this->articleManager = app(ArticleManager::class);
    }

    public function like($slug)
    {
        $this->articleManager->react(auth()->user(), Article::where('slug', $slug)->first(), true, false);
        return new JsonResponse([], 200);
    }

    public function dislike($slug)
    {
        $this->articleManager->react(auth()->user(), Article::where('slug', $slug)->first(), false, true);
        return new JsonResponse([], 200);
    }
}
