<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid email or password',
                'status_code' => 401,
            ], 401);
        } else {
            $user = Auth::user();
            // create token
            $token = $user->createToken($user)->plainTextToken;
            
            return response()->json([
                'access_token' => $token,
            ], 200);
        }

    }
}
