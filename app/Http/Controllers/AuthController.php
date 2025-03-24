<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\JwtService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;

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

    public function register(RegisterRequest $request) 
    {
        
        $user = $this->userService->register($request);

        return RegisterResource::make($user);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userService->login($request->validated());
        return LoginResource::make($user);
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

    // public function loginGuest(Request $request)
    // {
    //     $guestInfo = $this->guestService->Register();
    //     return $guestInfo;
    // }
    // public function logoutGuest(Request $request)
    // {
    //     $user = $this->guestService->logoutGuest($request->bearerToken());
    //     return $user;
    // }
}