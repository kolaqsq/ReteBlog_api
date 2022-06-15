<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\FileDeletionRequest;
use App\Http\Requests\User\FileUploadRequest;
use App\Managers\FileManager;
use Illuminate\Http\JsonResponse;

class FileController
{
    private FileManager $fileManager;

    public function __construct()
    {
        $this->fileManager = app(FileManager::class);
    }

    public function upload(FileUploadRequest $request)
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

        return $this->fileManager->save($data);
    }

    public function delete(FileDeletionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->fileManager->delete(auth()->user(), $data['filename']);
        return new JsonResponse([], 200);
    }
}
