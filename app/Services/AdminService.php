<?php

namespace App\Services;

use App\Models\User;
use App\Services\JwtService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;

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
        $token = $this->jwtService->generateToken($user);

        // Lưu token vào cookie
        $cookie = cookie('jwt_token', $token, 1); // 60 phút là thời gian sống của cookie, tùy chỉnh theo nhu cầu
    
        // Trả về response kèm cookie
        return response()->json([
            'message' => 'Login successful',
        ])->withCookie($cookie);
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