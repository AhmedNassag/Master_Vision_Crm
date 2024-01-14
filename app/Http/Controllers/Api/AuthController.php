<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();
        $token = auth()->user()->createToken('accessToken')->accessToken;

        return response(['user' => $user, 'access_token' => $token]);
    }
}
