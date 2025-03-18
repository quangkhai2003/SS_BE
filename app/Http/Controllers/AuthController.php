<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResgisterResourse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;

class AuthController extends Controller
{
    //
    protected $userService;

    // public function __construct(UserService $userService)
    // {
    //     $this->userService = $userService;
    // }

    public function register(UserRegisterRequest $request) {

        // $user = User::create([
        //     'username' => $request['username'],
        //     'full_name' => $request['full_name'],
        //     'email' => $request['email'],
        //     'password' => Hash::make($request['password']),
        //      ]);  
        //     $cookies = cookie('token', $user->createToken('token')->plainTextToken, 60 * 24, null, null, true);
        //     return UserResgisterResourse::make($user)->withCookie($cookies);
        //    return UserResgisterResourse::make($user);
        $user = $this->userService->create($request->validated());
        return UserResgisterResourse::make($user);
    }
    public function login() 
    {
        
    }
    public function user() {
        return "Hello User";
    }
}