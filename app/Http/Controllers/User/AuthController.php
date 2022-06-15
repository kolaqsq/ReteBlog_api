<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function logout()
    {
        session()->flush();
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
