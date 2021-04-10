<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    private $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param AuthLoginRequest $authLoginRequest
     * @return UserResource
     * @throws \App\Exceptions\LoginInvalidException
     */
    public function login(AuthLoginRequest $authLoginRequest)
    {
        $input = $authLoginRequest->validated();

        $token = $this->authService->login($input['email'], $input['password']);

        return (new UserResource(auth()->user()))->additional($token);
    }
}
