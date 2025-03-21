<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class JwtService
{
    public function generateToken(User $user)
    {
            $token = JWTAuth::fromUser($user);
            return [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ];
    }

    public function refreshToken()
    {
        $token = JWTAuth::parseToken()->refresh();
        $ttl = JWTAuth::factory()->getTTL() * 10;
        return [
            'refresh_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl
        ];
    }
    
    public function getToken()
    {
        return JWTAuth::getToken();
    }
    
    public function logout($token)
    {
        try {
            //$token = JWTAuth::getToken(); // Lấy token từ request
            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 400);
            }

            JWTAuth::invalidate($token); // Vô hiệu hóa token
            return response()->json(['message' => 'Logout success']);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has already expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

}