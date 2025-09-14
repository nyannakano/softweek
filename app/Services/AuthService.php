<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register($params)
    {
        $user = User::create([
            'email' => $params['email'],
            'password' => $params['password'],
            'cpf' => $params['cpf'],
            'ra' => $params['ra'],
            'name' => $params['name'],
        ]);

        Auth::login($user);

        $token = $user->createToken('my-api-token', ['read', 'write']);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function changeUserPassword($id, $params)
    {
        $user = User::find($id);
        $user->update([
            'password' => Hash::make($params['password']),
        ]);

        return $user;
    }
}
