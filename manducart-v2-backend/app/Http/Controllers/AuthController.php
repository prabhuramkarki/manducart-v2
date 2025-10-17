<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // Validate input
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create user (password hashing handled by User model mutator)
        $user = User::create([
            'name' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role ?? 'user',
        ]);

        return response()->json([
            'message' => 'Signup successful!',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
{
    // Validate input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Check user
    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    // Create token using Laravel Sanctum
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => $user,
    ], 200);
}


}
