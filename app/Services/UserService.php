<?php

namespace App\Services;

use App\Models\User;
use App\Services\JwtService;
use Illuminate\Database\Eloquent\Casts\Json;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Js;
use Illuminate\Http\JsonResponse;

class UserService
{
    protected $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function register(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return [
            'access_token' => $this->jwtService->generateToken($user)['access_token'],
        ];
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user || $user->role !== 'User' || !Hash::check($data['password'], $user->password)) {
            return "Không phải User";
        }

        $tokens = $this->jwtService->generateToken($user);

        return [
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
        ];
    }

    public function logout():JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
        
    }

    public function getProfile($token)
    {
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 400);
        }

        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 401);
        }

        $user = JWTAuth::user();
        return $user;
    }
}
