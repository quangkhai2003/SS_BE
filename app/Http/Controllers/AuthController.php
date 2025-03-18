<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResgisterResourse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(UserRegisterRequest $request) {
        try {
            // Tạo user
            $user = User::create([
                'username' => $request['username'],
                'full_name' => $request['full_name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            $cookies = cookie('token', $user->createToken('token')->plainTextToken, 60 * 24, null, null, true);
            return UserResgisterResourse::make($user)->withCookie($cookies);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Xử lý lỗi validation
            $errors = $e->errors();
            $message = 'Đăng ký không thành công.';
            if (isset($errors['username'])) {
                $message = 'Username đã tồn tại!';
            } elseif (isset($errors['email'])) {
                $message = 'Email đã tồn tại!';
            }
    
            return response()->json([
                'message' => $message,
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            // Xử lý các lỗi khác
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi đăng ký.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function user() {
        return "Hello User";
    }
}
