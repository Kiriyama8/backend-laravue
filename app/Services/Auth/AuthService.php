<?php

namespace App\Services\Auth;

use App\Exceptions\LoginInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Models\User;
use Illuminate\Support\Str;

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

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @throws UserHasBeenTakenException
     */
    public function register(string $firstName, string $lastName, string $email, string $password)
    {
        $user = User::where('email', $email)->exists();

        if (!empty($user)) {
            throw new UserHasBeenTakenException('Usuário já cadastrado');
        }

        $encryptPassword = bcrypt($password ?? Str::random(10));

        return User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $lastName,
            'password' => $encryptPassword,
            'confirmation_token' => Str::random(60)
        ]);
    }
}
