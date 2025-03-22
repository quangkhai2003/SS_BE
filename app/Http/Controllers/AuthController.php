<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserLoginResourse;
use App\Http\Resources\UserResgisterResourse;
use App\Services\UserService;


class AuthController extends Controller
{
    // UserService instance
    protected $userService;

    // Constructor to initialize UserService
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Method to register a new user
    public function register(UserRegisterRequest $request) {
        $user = $this->userService->create($request->validated());
        return $user;
    }

    // Method to login a user
    public function login(UserLoginRequest $request) 
    {
        $user = $this->userService->login($request->email, $request->password);
        return $user;
    }

    // Method to return a simple user greeting
    public function user() {
        return "Hello User";
    }
}
