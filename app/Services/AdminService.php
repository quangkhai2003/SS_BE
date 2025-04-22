<?php

namespace App\Services;

use App\Models\User;
use App\Services\JwtService;
use App\Services\UserService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AdminService
{

    protected $jwtService;
    protected $userService;

    public function __construct(JwtService $jwtService, UserService $userService)
    {
        $this->jwtService = $jwtService;
        $this->userService = $userService;
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
    public function getUser($username, $email)
    {
        $query = User::query();
        $query->where('role', '!=', 'Admin');
        // Nếu có username, tìm theo username
        if ($username) {
            $query->where('username', 'LIKE', "%{$username}%");
        }

        // Nếu có email, tìm theo email
        if ($email) {
            // Nếu đã có điều kiện username, dùng AND thay vì OR
            $query->where('email', 'LIKE', "%{$email}%");
        }

        // Lấy danh sách user
        $users = $query->get();
        if (!$users->isEmpty()) {
         
        }
        return $users;
    }
    public function getUsersByRole($request)
    {
    
        $users = User::where('role', $request)->get();

        if ($users->isEmpty()) {
            throw new \Exception("No user found");
        }
        return  $users;
    }
    public function getAllUser()
    {
        $users = User::whereIn('role', ['User', 'Guest'])->get();

        if ($users->isEmpty()) {
            throw new \Exception("No user found");
        }

        return $users;
    }
    public function deleteByEmail($email)
    {
        // Tìm user theo email
        $user = User::where('email', $email)->first();
        if (!$user) {
            throw new \Exception('User with email ' . $email . ' not found');
        }
        // Xóa user
        $this->userService->delete($user->user_id);
        return "deleted successfully";
    }
    public function updateByEmail($data)
    {
        $user = User::where('user_id', $data['user_id'])->firstOrFail();

        // Cập nhật các trường cần thiết
        $user->username = $data['username'] ?? $user->username;
        $user->email = $data['email'] ?? $user->email; // Cho phép cập nhật email mới
        $user->role = $data['role'] ?? $user->role;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return $user;
    }
    public function AddUser($data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'User',
        ]);
        return $user;
    }

}