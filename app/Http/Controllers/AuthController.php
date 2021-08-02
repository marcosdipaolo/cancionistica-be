<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = new User($request->only('name', 'email'));
            $hashed = bcrypt($request->get('password'));
            $user->password = $hashed;
            $user->save();
            $user->sendEmailVerificationNotification();
            return response()->json($user);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            \Log::info($credentials);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return response()->json(auth()->user());
            }

            return response()->json([
                'email' => 'The provided credentials do not match our records.',
            ], 403);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return response()->json(['message' => 'Logged out.']);
        } catch(\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}