<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use App\Services\JwtService;


class AdminController extends Controller 
{

    protected $adminService;
    protected $jwtService;

    public function __construct(AdminService $adminService, JwtService $jwtService)
    {
        $this->adminService = $adminService;
        $this->jwtService = $jwtService;
    }

    public function register(UserRegisterRequest $request) 
    {
        $user = $this->adminService->registerAdmin($request->validated());
        return $user;
    }

    public function login(UserLoginRequest $request)
    {
        $user = $this->adminService->loginAdmin($request->validated());
        return $user;
    }

    public function refresh(Request $request)
    {
        $user = $this->jwtService->refreshToken($request->bearerToken());
        return $user;
    } 

    public function logout()
    {
        $user = $this->adminService->logout();
        return $user;
    }
}