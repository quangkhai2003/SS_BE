<?php

namespace App\Services;

use App\Models\User;
use App\Services\JwtService;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserService
{
    protected $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function register(Request $data)
    {
        $user = User::create([
            'username' => $data['username'],
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
            throw new AuthenticationException('Invalid credentials or not an user');
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
            throw new AuthenticationException('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        return $user;
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return true;
    }
    public function getTopUsers()
    {
        // Lấy 50 user có điểm cao nhất, chỉ lấy role là User hoặc Guest
        return User::whereIn('role', ['User', 'Guest'])
        ->orderBy('point', 'desc')
        ->take(50)
        ->get(['username', 'point']); // Chỉ lấy các cột cần thiết
    }
}
