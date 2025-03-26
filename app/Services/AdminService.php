<?php

namespace App\Services;

use App\Models\User;
use App\Services\JwtService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AdminService
{

    protected $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function registerAdmin(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'Admin',
        ]);
        return [
            'access_token' => $this->jwtService->generateToken($user)['access_token'],
        ];
    }

    public function loginAdmin(Request $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user || $user->role !== 'Admin' || !Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException('Invalid credentials or not an admin');
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
}