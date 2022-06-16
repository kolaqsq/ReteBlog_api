<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\User\FileUploadRequest;
use App\Http\Requests\User\UserDeletionRequest;
use App\Managers\UserManager;
use App\Models\File;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserManager $userManager;

    public function __construct()
    {
        $this->userManager = app(UserManager::class);
    }

    public function profile(): JsonResponse
    {
        $user = auth()->user();
        $userResponse = json_encode($user);
        if (isset($user->file_id)) {
            return response()->json(
                array_merge(
                    json_decode($userResponse, true),
                    ['avatar' => asset('storage/' . File::where('id', $user->file_id)->first()->filename)]
                )
            );
        } else {
            return response()->json($user);
        }
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = auth()->user();
        $this->userManager->update($user, $request->validated());
        return new JsonResponse([], 200);
    }

    public function updateAvatar(FileUploadRequest $request)
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

        return $this->userManager->updateAvatar(auth()->user(), $data);
    }

    public function delete(UserDeletionRequest $request)
    {
        $this->userManager->delete(auth()->user(), $request->validated()['password']);
    }
}
