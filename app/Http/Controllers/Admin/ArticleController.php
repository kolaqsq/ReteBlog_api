<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleCreateRequest;
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

    public function store(ArticleCreateRequest $request): JsonResponse
    {
        $data = array_merge($request->validated(), [
            'user_id' => $request->user()->id,
        ]);

        $this->articleManager->create($data);
        return new JsonResponse([], 200);
    }

    public function update($slug, ArticleCreateRequest $request): JsonResponse
    {
        $article = Article::where('slug', $slug)->first();
        $this->articleManager->update($article, $request->validated());
        return new JsonResponse([], 200);
    }

    public function delete($slug): JsonResponse
    {
        $article = Article::where('slug', $slug)->first();
        $this->articleManager->delete($article);
        return new JsonResponse([], 200);
    }
}
