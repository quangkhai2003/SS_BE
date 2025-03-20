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
        if (!$authHeader) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $token = explode(' ', $authHeader)[1]; // Tách chuỗi "Bearer {token}" để lấy token
        $user = JWTAuth::parseToken()->authenticate($token); // Lấy thông tin user từ token
        if ($user->role !== $role) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }
        // Nếu user có role trùng khớp với role được yêu cầu, tiếp tục thực thi request

        return $next($request);
    }
}