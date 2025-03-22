<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;


class AdminController extends Controller 
{

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
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

    public function logout()
    {
        $user = $this->adminService->logout();
        return $user;
    }
}