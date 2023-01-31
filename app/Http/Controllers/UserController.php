<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Users\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;


class UserController extends Controller
{

    protected UserServiceInterface $userService;

    public function __construct(
        UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @param UserLoginRequest $request
     * @return array|string
     */
    public function login(UserLoginRequest $request): array|string
    {
        return $this->userService->login(
            $request->email,
            $request->password,
            $request->phone
        );
    }


    /**
     * @param UserRegisterRequest $request
     * @return array|UserResource
     */
    public function register(UserRegisterRequest $request): array|UserResource
    {
        return $this->userService->register([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'terms' => $request->terms
        ], true);
    }
}
