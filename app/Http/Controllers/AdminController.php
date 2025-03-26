<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Services\AdminService;



class AdminController extends Controller 
{

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function register(RegisterRequest $request) 
    {
        $user = $this->adminService->registerAdmin($request->validated());
        return RegisterResource::make($user);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->adminService->loginAdmin($request);
        return LoginResource::make($user);
    }

    public function logout()
    {
        $user = $this->adminService->logout();
        return $user;
    }
}