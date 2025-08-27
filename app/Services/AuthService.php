<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function register($params)
    {
        return User::create([
            'email' => $params['email'],
            'password' => $params['password'],
            'cpf' => $params['cpf'],
            'ra' => $params['ra'],
        ]);
    }
}
