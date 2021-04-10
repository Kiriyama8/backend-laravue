<?php

namespace App\Services\Auth;

use App\Exceptions\LoginInvalidException;

class AuthService
{
    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws LoginInvalidException
     */
    public function login(string $email, string $password)
    {
        $login = [
            'email' => $email,
            'password' => $password
        ];

        if (!$token = auth()->attempt($login)) {
            throw new LoginInvalidException('Login e/ou senha inválida');
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }
}
