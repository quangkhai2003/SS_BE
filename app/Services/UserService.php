<?php

namespace App\Services;

use App\Models\User;
use App\Services\JwtService;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    protected $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return [
            'user'=> $user,
            'access_token' => $this->jwtService->generateToken($user)['access_token'],
            'refresh_token' => $this->jwtService->generateToken($user)['refresh_token'],
        ];
    }

    public function createAdmin(Array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'Admin',
        ]);
        return [
            'user'=> $user,
            'access_token' => $this->jwtService->generateToken($user)['access_token'],
        ];
    }
    
    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user || $user->role !== 'User' || !Hash::check($data['password'], $user->password)) {
            return "Không phải User"; // hoặc trả về response lỗi phù hợp
        }

        $access_token = $this->jwtService->generateToken($user)['access_token'];

        //$refreshToken = $this->jwtService->refreshToken()['refresh_token'];

        return [
            'user' => $user,
            'access_Token' => $access_token,
            //'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            //'expires_in' => JWTAuth::factory()->getTTL() * 30,
        ];
    }

    public function loginAdmin(Array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user || $user->role !== 'Admin' || !Hash::check($data['password'], $user->password)) {
            return 'Không phải admin'; // hoặc trả về response lỗi phù hợp
        }
        return [
            'user' => $user,
            'access_Token' => $this->jwtService->generateToken($user)['access_token'],
        ];
    }

    public function logout($token)
    {
        //return $this->jwtService->logout($token);
        dd($this->jwtService->getToken());
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function delete(array $data)
    {

    }
}
