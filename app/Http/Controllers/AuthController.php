<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResgisterResourse;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
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

       

        $user = User::create([
            'username' => $request['username'],
            'full_name' => $request['full_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
        
    }
    public function user() {
        return "Hello User";
    }
}
