<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RefreshResource;
use App\Http\Resources\RegisterResource;
use App\Http\Resources\UserResource;
use App\Services\AdminService;
use App\Services\JwtService;
use Illuminate\Http\Request;

class AdminController extends Controller 
{

    protected $adminService;
    protected $jwtService;
    public function __construct(AdminService $adminService, JwtService $jwtService)
    {
        $this->adminService = $adminService;
        $this->jwtService = $jwtService;
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
    public function refresh(Request $request)
    {
        $user = $this->jwtService->refreshToken($request->bearerToken());
        return  RefreshResource::make($user);
    }
    public function logout()
    {
        $user = $this->adminService->logout();
        return $user;
    }
    public function getUser(Request $request)
    {
        $user = $this->adminService->getUser($request->username, $request->email);
        return UserResource::collection($user);
    }
    public function getAllUser()
    {
        $user = $this->adminService->getAllUser();
        return UserResource::collection($user);
    }
    public function getUsersByRole(Request $request)
    {
        $users = $this->adminService->getUsersByRole($request->role);
        return UserResource::collection($users);
    }
    public function deleteByEmail(Request $request)
    {
        return $this->adminService->deleteByEmail($request->email);   
    }
    public function updateByEmail(UpdateUserRequest $request)
    {
        $user = $this->adminService->updateByEmail($request->validated());
        return UserResource::make($user);
    }
    public function AddUser(RegisterRequest $request)
    {
        $user = $this->adminService->AddUser($request->validated());
        return UserResource::make($user);
    }
} 