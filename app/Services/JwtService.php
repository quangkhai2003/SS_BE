<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class JwtService
{
    public function generateToken(User $user)
    {
        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = JWTAuth::claims(['refresh' => true, 'exp' => now()->addDays(7)->timestamp])->fromUser($user);

        return response()->json([
            'message' => 'Token generated successfully',
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60 // Chuyển sang giây
        ])
        ->cookie('access_token', $accessToken, JWTAuth::factory()->getTTL(), '/', null, config('app.env') === 'local', true, false, 'Strict')
        ->cookie('refresh_token', $refreshToken, 10080, '/', null, config('app.env') === 'local', true, false, 'Strict'); // 7 ngày = 10080 phút
    }

    public function refreshToken($refreshToken)
    {
        try {
            JWTAuth::setToken($refreshToken);
            $claims = JWTAuth::getPayload()->toArray();

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

            return [
                'access_token' => $newTokens['access_token'],
            ];
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Refresh token expired. Please log in again.'], 401);
        } catch (TokenInvalidException | TokenBlacklistedException $e) {
            return response()->json(['error' => 'Invalid refresh token.'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not refresh token.'], 400);
        }
    }

    public function authenticateFromCookie()
    {
        $accessToken = request()->cookie('access_token');

        if (!$accessToken) {
            return response()->json(['error' => 'No access token provided'], 401);
        }

        try {
            $user = JWTAuth::setToken($accessToken)->authenticate();
            if (!$user) {
                return response()->json(['error' => 'Invalid token'], 401);
            }
            auth()->setUser($user);
            return $user;
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (TokenInvalidException | TokenBlacklistedException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not decode token'], 400);
        }
    }

    public function logout()
    {
        return response()->json(['message' => 'Logged out successfully'])
            ->cookie(Cookie::forget('access_token'))
            ->cookie(Cookie::forget('refresh_token'));
    }
    

}
