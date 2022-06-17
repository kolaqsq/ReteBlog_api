<?php

namespace App\Http\Controllers;

use App\Managers\ArticleManager;
use App\Models\Article;
use App\Models\File;
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
            Article::orderBy('created_at', 'desc')->cursorPaginate(
                $perPage = 16,
                $columns = ['title', 'slug', 'created_at', 'poster_link']
            )
        );
    }

    public function showArticle($slug): JsonResponse
    {
        $article = Article::where('slug', $slug)->first();
        $articleResponse = json_encode($article);

        $this->articleManager->viewCount(session(), Article::where('slug', $slug)->first());
        return response()->json(array_merge(
                                    json_decode($articleResponse, true),
                                    ['author' => $article->user->first_name . ' ' . $article->user->first_name]
                                ));
    }

    public function search(Request $request): JsonResponse
    {
        return response()->json(
            Article::where('title', 'like', '%' . $request->search . '%')
//                ->orWhere('content', 'like', '%'.$request->search.'%')
                ->orderBy('created_at', 'desc')
                ->cursorPaginate(
                    $perPage = 16,
                    $columns = ['title', 'slug', 'created_at', 'poster_link']
                )
        );
    }
}
