<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleCreateRequest;
use App\Http\Requests\User\FileDeletionRequest;
use App\Http\Requests\User\FileUploadRequest;
use App\Managers\ArticleManager;
use App\Models\Article;
use App\Models\File;
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

        if (!isset($data['disk'])) {
            $data['disk'] = 'public';
        }

        if (!isset($data['path'])) {
            $data['path'] = '';
        }

        $this->articleManager->create($data);
        return new JsonResponse([], 200);
    }

    public function update($slug, ArticleCreateRequest $request): JsonResponse
    {
        $data = array_merge($request->validated(), [
            'user_id' => $request->user()->id,
        ]);

        if (!isset($data['disk'])) {
            $data['disk'] = 'public';
        }

        if (!isset($data['path'])) {
            $data['path'] = '';
        }

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

    public function uploadFile($slug, FileUploadRequest $request)
    {
        $data = array_merge($request->validated(), [
            'user_id' => $request->user()->id,
        ]);

        if (!isset($data['disk'])) {
            $data['disk'] = 'public';
        }

        if (!isset($data['path'])) {
            $data['path'] = 'article';
        }

        $filename = $this->articleManager->uploadFile(Article::where('slug', $slug)->first(), $data);

        return response()->json(['file' => asset('storage/' . $filename)]);
    }

    public function deleteFile($slug, FileDeletionRequest $request)
    {
        $data = $request->validated();
        $this->articleManager->deleteFile(auth()->user(), Article::where('slug', $slug)->first(), $data['filename']);
        return new JsonResponse([], 200);
    }
}
