<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthForgotPasswordRequest;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Requests\Auth\AuthVerifyEmailRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
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
    public function login(AuthLoginRequest $authLoginRequest): UserResource
    {
        $input = $authLoginRequest->validated();

        $token = $this->authService->login($input['email'], $input['password']);

        return (new UserResource(auth()->user()))->additional($token);
    }

    /**
     * @throws \App\Exceptions\UserHasBeenTakenException
     */
    public function register(AuthRegisterRequest $authRegisterRequest): UserResource
    {
        $input = $authRegisterRequest->validated();

        $user = $this->authService->register($input['first_name'], $input['last_name'] ?? '', $input['email'], $input['password']);

        return (new UserResource($user));
    }

    /**
     * @param AuthVerifyEmailRequest $authVerifyEmailRequest
     * @return UserResource
     * @throws \App\Exceptions\VerifyEmailTokenInvalidException
     */
    public function verifyEmail(AuthVerifyEmailRequest $authVerifyEmailRequest): UserResource
    {
        $input = $authVerifyEmailRequest->validated();

        $user = $this->authService->verifyEmail($input['token']);

        return (new UserResource($user));
    }

    /**
     * @param \App\Http\Requests\Auth\AuthForgotPasswordRequest $authForgotPasswordRequest
     */
    public function forgotPassword(AuthForgotPasswordRequest $authForgotPasswordRequest)
    {
        $input = $authForgotPasswordRequest->validated();

        return $this->authService->forgotPassword($input['email']);
    }

    public function resetPassword(ResetPasswordRequest $resetPasswordRequest)
    {
        $input = $resetPasswordRequest->validated();

        $this->authService->resetPassword($input['email'], $input['password'], $input['token']);
    }
}
