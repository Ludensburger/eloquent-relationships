<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Login user and generate or return existing valid token
     */
    public function login(Request $request)
    {

        // If i want to specify only JSON response IN Login only
        // Force JSON response regardless of Accept header
        // $request->headers->set('Accept', 'application/json');

        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        $user = User::where('name', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if user has an existing token that hasn't expired
        $existingToken = $user->tokens()
            ->where('name', 'api-token')
            ->where('created_at', '>', Carbon::now()->subDay())
            ->first();

        if ($existingToken) {
            // For existing tokens, we can't retrieve the plain text token
            // So we'll delete the old token and create a new one
            $existingToken->delete();
        }

        // Create new token that expires in 24 hours
        $token = $user->createToken('api-token', ['*'], Carbon::now()->addDay());

        return response()->json([
            'message' => 'Login successful',
            'token' => $token->plainTextToken,
            'user' => $user,
            'expires_at' => Carbon::now()->addDay(),
            'token_created' => true
        ]);
    }

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create token that expires in 24 hours
        $token = $user->createToken('api-token', ['*'], Carbon::now()->addDay());

        return response()->json([
            'message' => 'Registration successful',
            'token' => $token->plainTextToken,
            'user' => $user,
            'expires_at' => Carbon::now()->addDay(),
            'token_created' => true
        ], 201);
    }

    /**
     * Logout user and delete current token
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get authenticated user info
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $currentToken = $user->currentAccessToken();

        return response()->json([
            'user' => $user,
            'token_expires_at' => $currentToken->expires_at,
            'token_created_at' => $currentToken->created_at,
            'is_token_valid' => $currentToken->created_at > Carbon::now()->subDay()
        ]);
    }

    /**
     * Refresh token if it's expired
     */
    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $currentToken = $user->currentAccessToken();

        // Check if token is still valid (less than 24 hours old)
        if ($currentToken->created_at > Carbon::now()->subDay()) {
            return response()->json([
                'message' => 'Token is still valid',
                'token' => 'current-token-still-valid',
                'expires_at' => $currentToken->created_at->addDay(),
                'token_refreshed' => false
            ]);
        }

        // Delete old token and create new one
        $currentToken->delete();
        $newToken = $user->createToken('api-token', ['*'], Carbon::now()->addDay());

        return response()->json([
            'message' => 'Token refreshed successfully',
            'token' => $newToken->plainTextToken,
            'expires_at' => Carbon::now()->addDay(),
            'token_refreshed' => true
        ]);
    }
}
