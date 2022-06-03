<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckUsernameRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Managers\UserManager;
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
        return response()->json(auth()->user());
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = auth()->user();
        $this->userManager->update($user, $request->validated());
        return new JsonResponse([], 200);
    }
}
