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
        $user = $this->userService->create($request->validated());
        return $user;
    }

    public function login(UserLoginRequest $request)
    {
        $user = $this->userService->login($request->validated());
        return $user;
    }

    public function logout(Request $request) 
    {
        $user = $this->jwtService->logout($request->bearerToken());
        return $user;
    }
    
}