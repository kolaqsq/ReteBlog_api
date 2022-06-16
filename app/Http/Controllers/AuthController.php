<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckUsernameRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Managers\UserManager;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private UserManager $userManager;

    public function __construct()
    {
        $this->userManager = app(UserManager::class);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        $token = $this->userManager->auth($email, $password, $remember);

        return new JsonResponse(['Authorization' => "Bearer $token"], 200);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $token = $this->userManager->register($request->validated());

        return new JsonResponse(['Authorization' => "Bearer $token"], 201,);
    }

    public function checkUsername(CheckUsernameRequest $request): JsonResponse
    {
        $this->userManager->checkUsername($request);
        return new JsonResponse([], 200);
    }
}
