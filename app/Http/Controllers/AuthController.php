<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserLoginResourse;
use App\Http\Resources\UserResgisterResourse;
use App\Services\UserService;


class AuthController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRegisterRequest $request) 
    {
        $user = $this->userService->create($request->validated());
        return $user;
    }

    public function login(UserLoginRequest $request)
    {
        $user = $this->userService->login($request->email, $request->password);
        return $user;
    }
    // public function logout() 
    // {
    //     $this->userService->logout();
    //     return response()->json(['message' => 'Đăng xuất thành công']);
    // }
    
    public function user() {
        return "Hello";
    }
}