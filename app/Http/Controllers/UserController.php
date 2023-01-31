<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(UserLoginRequest $request): JsonResponse
    {
        return response()->json(['message' => 'success']);
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        return response()->json(['message' => 'success']);
    }
}
