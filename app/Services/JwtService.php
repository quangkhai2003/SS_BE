<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtService
{
    public function generateToken(User $user)
    {
        try {
            $token = JWTAuth::fromUser($user);
            return [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ];
        } catch (\Exception $e) {
            throw new \Exception('Could not generate token: ' . $e->getMessage());
        }
    }

    // public function refreshToken()
    // {
    //     try {
    //         $token = JWTAuth::parseToken()->refresh();
    //         return [
    //             'access_token' => $token,
    //             'token_type' => 'bearer',
    //             'expires_in' => JWTAuth::factory()->getTTL() * 60
    //         ];
    //     } catch (\Exception $e) {
    //         throw new \Exception('Could not refresh token: ' . $e->getMessage());
    //     }
    // }

    

}