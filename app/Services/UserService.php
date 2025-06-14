<?php

namespace App\Services;

use App\Http\Resources\MessageResources;
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
            'avatar' => 'default_avatar',
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

    public function logout(): JsonResponse
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

        $topUsers = $this->getTopUsers();

        // Tìm rank của user hiện tại trong danh sách top users
        $rank = $topUsers->firstWhere('username', $user->username)->rank ?? null;
        if (!$rank) {
            $rank = User::where(function ($query) use ($user) {
                $query->where('point', '>', $user->point)
                      ->orWhere(function ($subQuery) use ($user) {
                          $subQuery->where('point', '=', $user->point)
                                   ->where('user_id', '<', $user->user_id); // Ưu tiên user có ID nhỏ hơn
                      });
            })
            ->whereIn('role', ['User', 'Guest'])
            ->count() + 1;
        }
        return response()->json([
            'user' => [
                'user_id' => $user->user_id,
                'username' => $user->username,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'point' => $user->point,
                'role' => $user->role,
                'study_day' => $user->study_day,
                'last_login_at' => $user->last_login_at,
                'rank' => $rank,
            ],
        ]);
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
        $users = User::whereIn('role', ['User', 'Guest'])
            ->orderBy('point', 'desc')
            ->take(50)
            ->get(['avatar', 'username', 'point']);

        // Thêm rank cho từng user
        $rankedUsers = $users->map(function ($user, $index) {
            $user->rank = $index + 1; // Rank bắt đầu từ 1
            return $user;
        });

        return $rankedUsers;
    }
    public function checkIn7Day($token)
    {
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new AuthenticationException('Token is invalid or expired');
        }

        $user = JWTAuth::user();

        // Check if last_login_at is null or on a different day
        $today = now()->startOfDay();
        $lastLoginDay = $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->startOfDay() : null;

        // Nếu đã điểm danh hôm nay, không cho phép điểm danh nữa
        if ($lastLoginDay && $lastLoginDay->eq($today)) {
            return ['message' => ('You have checked in today')];
        }

        // Nếu chưa điểm danh, tăng số ngày học
        $user->increment('study_day');

        // Update last_login_at to the current timestamp
        $user->last_login_at = now();
        $user->save();

        // Tặng điểm theo mốc ngày (dựa trên study_day % 7)
        $bonusPoints = 0; // 16 mod 
        $dayInCycle = $user->study_day % 7; // Tính ngày trong chu kỳ 7 ngày
        if ($dayInCycle == 0) {
            $dayInCycle = 7; // Nếu là ngày 0, chuyển thành ngày 7
        }

        switch ($dayInCycle) {
            case 1:
                $bonusPoints = 20; // Ngày 1 tặng 20 điểm
                break;
            case 2:
                $bonusPoints = 20; // Ngày 2 tặng 20 điểm
                break;
            case 3:
                $bonusPoints = 30; // Ngày 3 tặng 30 điểm
                break;
            case 4:
                $bonusPoints = 30; // Ngày 3 tặng 30 điểm
                break;
            case 5:
                $bonusPoints = 50; // Ngày 5 tặng 50 điểm
                break;
            case 6:
                $bonusPoints = 50; // Ngày 5 tặng 50 điểm
                break;
            case 7:
                $bonusPoints = 100; // Ngày 7 tặng 100 điểm
                break;
        }

        // Cộng điểm thưởng nếu có
        if ($bonusPoints > 0) {
            $user->increment('point', $bonusPoints);
        }

        return ['message' => ('Login successful'), 'day login' => ($dayInCycle)];
    }
    public function getCheckInDays($token)
    {
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new AuthenticationException('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        $dayInCycle = $user->study_day % 7;
        return ['day login' => ($dayInCycle)];
    }
    public function updateAvatar($token, $avatar)
    {
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new AuthenticationException('Token is invalid or expired');
        }

        $user = JWTAuth::user();

        // Kiểm tra tên avatar có hợp lệ không (avatar_0 đến avatar_29)
        if (!preg_match('/^avatar_([0-9]|[1-2][0-9])$/', $avatar)) {
            return ['message' => ('Invalid avatar name')];
        }

        // Cập nhật avatar
        $user->avatar = $avatar;
        $user->save();

        return [
            'message' => 'Avatar updated successfully',
            'avatar' => $user->avatar,
        ];
    }
}
