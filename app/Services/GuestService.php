<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\UserService;

class GuestService
{
    protected $jwtService;
    protected $userService;
    public function __construct(JwtService $jwtService, UserService $userService)
    {
        $this->jwtService = $jwtService;
        $this->userService = $userService;
    }

    public function Register()
    {
        $randomNumbers = str_pad(mt_rand(0, 999999999), 10, '0', STR_PAD_LEFT); // Tạo số ngẫu nhiên 10 chữ số
        $randomUser = "Guest" . $randomNumbers;

        // Gắn giá trị cho các trường
        $data = [
            'username' => $randomUser,
            'full_name' => $randomUser,
            'email' => $randomUser . '@gmail.com',
            'password' => $randomUser, // Password cũng dùng randomUser để đảm bảo đủ 8 ký tự
        ];
        $user = User::create([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'Guest',
        ]);
        $tokens = $this->jwtService->generateToken($user);

        return [
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
        ];
    }
    public function logoutGuest(): JsonResponse
    {
        $user = JWTAuth::parseToken()->authenticate();

        // Kiểm tra nếu người dùng là khách
        if ($user->role === 'Guest') {
            // Vô hiệu hóa token
            JWTAuth::invalidate(JWTAuth::getToken());

            // Xóa tài khoản khách
            $this->userService->delete($user->user_id);

            return response()->json([
                'message' => 'Guest user logged out and account deleted successfully',
            ], 200);
        }
        return response()->json([
            'message' => 'User is not a guest',
        ], 400);
    }
}
