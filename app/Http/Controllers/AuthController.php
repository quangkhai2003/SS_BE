<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\JwtService;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    //
    protected $userService;
    protected $jwtService;

    public function __construct(UserService $userService, JwtService $jwtService)
    {
        $this->userService = $userService;
        $this->jwtService = $jwtService;
    }

    public function register(UserRegisterRequest $request) 
    {
        $user = $this->userService->register($request->validated());
        return $user;
    }

    public function login(UserLoginRequest $request)
    {
        $user = $this->userService->login($request->validated());
        return $user;
    }

    public function logout(Request $request) 
    {
        $user = $this->userService->logout($request->bearerToken());
        return $user;
    }

    public function refresh(Request $request)
    {
        $user = $this->jwtService->refreshToken($request->bearerToken());
        return $user;
    }

    public function profile(Request $request)
    {
        $user = $this->userService->getProfile($request->bearerToken());
        return $user;
    }
    
}