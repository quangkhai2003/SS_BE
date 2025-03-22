<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class JwtService
{
    public function generateToken(User $user)
    {
        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = JWTAuth::claims(['refresh' => true])->fromUser($user);

        return [
            'message' => 'Token generated successfully',
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }

    public function refreshToken($refreshToken)
    {
        try {
            // Set token và lấy payload
            JWTAuth::setToken($refreshToken);
            $claims = JWTAuth::getPayload()->toArray();

            // Kiểm tra token có phải refresh token không
            if (!isset($claims['refresh']) || !$claims['refresh']) {
                return response()->json(['error' => 'Invalid refresh token'], 401);
            }

            // Lấy user từ `sub` (User ID trong token)
            $userId = $claims['sub'];
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Tạo access token và refresh token mới
            $newTokens = $this->generateToken($user);

            return response()->json([
                'access_token' => $newTokens['access_token'],
                'refresh_token' => $newTokens['refresh_token'],
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Refresh token expired. Please log in again.'], 401);
        } catch (TokenInvalidException | TokenBlacklistedException $e) {
            return response()->json(['error' => 'Invalid refresh token.'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not refresh token.'], 400);
        }
    }

    

}
