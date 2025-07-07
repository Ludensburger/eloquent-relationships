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
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::where('name', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if user has a valid (non-expired) token
        $existingToken = $user->tokens()
            ->where('expires_at', '>', now())
            ->first();

        if ($existingToken) {
            // Token is still valid - just confirm login, DON'T create new token
            return response()->json([
                'message' => 'Login successful - using existing token',
                'user' => $user,
                'token_status' => 'valid',
                'token_expires_at' => $existingToken->expires_at,
                'note' => 'Continue using your existing token'
            ]);
        }

        // Only create new token if the old one expired
        $user->tokens()->delete(); // Clean up expired tokens
        $token = $user->createToken('auth-token', ['*'], now()->addDay());

        return response()->json([
            'message' => 'Login successful - new token created',
            'user' => $user,
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'token_expires_at' => $token->accessToken->expires_at,
        ]);
    }

    public function logout(Request $request)
    {
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
