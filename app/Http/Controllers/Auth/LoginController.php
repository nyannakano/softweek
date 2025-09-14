<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'User authenticated with success',
                'token' => $token,
            ], 200);
        }

        return response()->json(['message' => 'Credentials not match'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'cpf' => 'required|string|min_digits:11|max_digits:11|unique:users,cpf',
            'ra' => 'required|string|unique:users,ra',
            'name' => 'required|string',
        ]);

        $user = $this->authService->register($request->all());

        return response()->json([
            'message' => 'User registered with success',
            'user' => $user['user'],
            'token' => $user['token'],
        ], 201);
    }

    public function changeUserPassword($id, Request $request)
    {
        try {
            $this->authService->changeUserPassword($id, $request->all());

            return response()->json([
                'message' => 'User password changed with success',
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao alterar senha',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
