<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class MeController extends Controller
{
    /**
     * MeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return UserResource
     */
    public function index(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function update(MeUpdateRequest $meUpdateRequest)
    {
        $input = $meUpdateRequest->validated();

        $authUser = auth()->user();

        $user = (new UserService())->update($authUser, $input);

        return new UserResource($user);
    }
}
