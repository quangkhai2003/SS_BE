<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $authHeader = $request->header('Authorization'); // Lấy giá trị của Authorization header
        $roles = explode('|', $role); // Tách chuỗi các role bằng dấu "|"
        if (!$authHeader) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $token = explode(' ', $authHeader)[1]; // Tách chuỗi "Bearer {token}" để lấy token
        $user = JWTAuth::parseToken()->authenticate($token); // Lấy thông tin user từ token
        if (!$user && !in_array($user->role, $roles)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }
        
        return $next($request);
    }
}