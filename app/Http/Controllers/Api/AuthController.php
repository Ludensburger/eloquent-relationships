<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Delete any existing tokens for this user
        $user->tokens()->delete();

        // Create a new token that expires in 1 day
        $token = $user->createToken('auth_token', ['*'], now()->addDay())->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('name', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Delete expired tokens
        $user->tokens()->where('expires_at', '<=', now())->delete();

        // If a valid token still exists, don't create a new one (but you can't retrieve the token string)
        $existingToken = $user->tokens()->where('expires_at', '>', now())->first();

        if ($existingToken) {
            return response()->json([
                'message' => 'Already logged in with valid token. Please use stored token.',
                'user' => $user,
                'token_hint' => 'Token is still valid. Use the stored token on client side.',
                'token_type' => 'Bearer',
                'token_expires_at' => $existingToken->expires_at,
            ]);
        }

        // Create new token
        $token = $user->createToken('auth_token', ['*'], now()->addDay())->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }


    public function logout(Request $request)
    {
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
