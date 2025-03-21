<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResgisterResourse;
use App\Models\User;
use App\Http\Requests\RoadMapRequest;
use App\Services\RoadMapService;

class AdminController extends Controller 
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRegisterRequest $request) 
    {
        $user = $this->userService->createAdmin($request->validated());
        return $user;
    }

    public function login(UserLoginRequest $request)
    {
        $user = $this->userService->loginAdmin($request->validated());
        return $user;
    }

   

    public function logout(){

    }
}