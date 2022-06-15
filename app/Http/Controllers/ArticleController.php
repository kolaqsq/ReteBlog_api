<?php

namespace App\Http\Controllers;

use App\Managers\ArticleManager;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private ArticleManager $articleManager;

    public function __construct()
    {
        $this->articleManager = app(ArticleManager::class);
    }

    public function listAll(): JsonResponse
    {
        return response()->json(
            Article::orderBy('updated_at', 'desc')->cursorPaginate(
                $perPage = 16,
                $columns = ['title', 'slug', 'views', 'likes', 'dislikes',]
            )
        );
    }

    public function showArticle($slug): JsonResponse
    {
        $this->articleManager->viewCount(session(), Article::where('slug', $slug)->first());
        return response()->json(Article::where('slug', $slug)->first());
    }

    public function search(Request $request): JsonResponse
    {
        return response()->json(
            Article::where('title', 'like', '%' . $request->search . '%')
//                ->orWhere('content', 'like', '%'.$request->search.'%')
                ->orderBy('updated_at', 'desc')
                ->cursorPaginate(
                    $perPage = 16,
                    $columns = ['title', 'slug', 'views', 'likes', 'dislikes',]
                )
        );
    }
}
