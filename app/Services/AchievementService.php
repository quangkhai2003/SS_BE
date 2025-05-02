<?php

namespace App\Services;

use App\Http\Resources\AchievementClaimResource;
use App\Http\Resources\MessageResources;
use App\Models\Achievement;
use App\Models\Your_Dictionary;
use App\Models\YourAchievement;
use App\Models\YourLevel;
use Tymon\JWTAuth\Claims\Claim;
use Tymon\JWTAuth\Facades\JWTAuth;

class AchievementService
{
    /**
     * Lấy danh sách tất cả các Achievement
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllAchievements()
    {
        // Lấy toàn bộ dữ liệu từ bảng achievements
        return Achievement::all();
    }
    public function checkUserStats($token)
    {
        // Lấy user từ token
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new \Exception('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Lấy thông tin study_day từ bảng users
        $studyDay = $user->study_day ?? 0;

        // Lấy level cao nhất từ bảng Your_Level, nếu không có thì trả về 0
        $highestLevel = YourLevel::where('user_id', $user->user_id)->max('level_id') ?? 0;

        // Đếm số lượng từ trong bảng Your_Dictionary, nếu không có thì trả về 0
        $wordCount = Your_Dictionary::where('user_id', $user->user_id)->count() ?? 0;

        return [
            'study_day' => $studyDay,
            'highest_level' => $highestLevel,
            'word_count' => $wordCount,
        ];
    }
    public function checkAndInsertAchievements($token)
    {
        // Lấy user từ token
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new \Exception('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Lấy thông tin người dùng
        $userStats = [
            'study_day' => $user->study_day ?? 0,
            'highest_level' => YourLevel::where('user_id', $user->user_id)->max('level_id') ?? 0,
            'word_count' => Your_Dictionary::where('user_id', $user->user_id)->count() ?? 0,
        ];



        // Lấy danh sách tất cả các achievements
        $achievements = Achievement::all();


        $result = [];

        foreach ($achievements as $achievement) {
            $requirement = (int) $achievement->requirement;
            $progress = 0; // Tiến trình hiện tại
            $calculatedStatus = 'incomplete'; // Trạng thái tính toán dựa trên tiến trình

            // Kiểm tra điều kiện dựa trên type
            switch ($achievement->type) {
                case 'Date':
                    $progress = $userStats['study_day'];
                    if ($progress >= $requirement) {
                        $calculatedStatus = 'complete';
                        $progress = $requirement; // Đảm bảo hiển thị req/req khi complete
                    }
                    break;
                case 'Level':
                    $progress = $userStats['highest_level'];
                    if ($progress >= $requirement) {
                        $calculatedStatus = 'complete';
                        $progress = $requirement; // Đảm bảo hiển thị req/req khi complete
                    }
                    break;
                case 'Word':
                    $progress = $userStats['word_count'];
                    if ($progress >= $requirement) {
                        $calculatedStatus = 'complete';
                        $progress = $requirement; // Đảm bảo hiển thị req/req khi complete
                    }
                    break;
            }

            // Lấy trạng thái từ bảng YourAchievement
            $userAchievement = YourAchievement::where('user_id', $user->user_id)
                ->where('achievement_id', $achievement->achievement_id)
                ->first();

            $dbStatus = $userAchievement ? $userAchievement->status : 'incomplete';

            if (!$userAchievement && $calculatedStatus === 'complete') {
                // Thêm bản ghi vào bảng your_achievements
                YourAchievement::create([
                    'user_id' => $user->user_id,
                    'achievement_id' => $achievement->achievement_id,
                    'status' => 'incomplete',
                    'created_at' => now()->startOfDay(),
                ]);
            }

            // Thêm thông tin achievement vào kết quả
            $result[] = [
                'achievement_id' => $achievement->achievement_id,
                'name' => $achievement->name,
                'type' => $achievement->type,
                'progress' => "{$progress}/{$requirement}",
                'status' => $calculatedStatus, // Trạng thái tính toán
                'status_claim' => $dbStatus, // Trạng thái từ bảng YourAchievement
            ];
        }

        return $result;
    }
    public function claimAchievement($token, $achievementId)
    {
        // Lấy user từ token
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new \Exception('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Kiểm tra xem thành tích có tồn tại không
        $achievement = Achievement::find($achievementId);
        if (!$achievement) {
            return MessageResources::createMessageResource('Achievement not found');
        }

        // Kiểm tra trạng thái thành tích của người dùng
        $userAchievement = YourAchievement::where('user_id', $user->user_id)
            ->where('achievement_id', $achievementId)
            ->first();

        if (!$userAchievement) {
            return MessageResources::createMessageResource('Achievement not found for this user');
        }
        if ($userAchievement->status === 'complete') {
            return MessageResources::createMessageResource('Achievement already claimed');
        }
        // Cập nhật trạng thái thành tích thành "complete"
        $userAchievement->status = 'complete';
        $userAchievement->save();
        $bonus_points = $achievement->bonus_points ?? 0; // Giả sử bảng achievements có cột reward_points
        $user->point = ($user->point ?? 0) + $bonus_points;
        $user->save();

        $result = [
            'achievement_id' => $achievementId,
            'achievement_sticker' => $achievement->sticker,
            'status' => 'complete',
        ];
        return AchievementClaimResource::make($result);
    }
    public function getUserSticker($token)
    {
        // Lấy user từ token
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new \Exception('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Lấy danh sách các thành tích có trạng thái "complete"
        $completedAchievements = YourAchievement::where('user_id', $user->user_id)
            ->where('status', 'complete')
            ->pluck('achievement_id');

        // Lấy sticker từ bảng Achievement dựa trên danh sách achievement_id
        $stickers = Achievement::whereIn('achievement_id', $completedAchievements)
            ->pluck('sticker');

        // Lấy tên và sticker từ bảng Achievement dựa trên danh sách achievement_id
        $achievements = Achievement::whereIn('achievement_id', $completedAchievements)
            ->get(['name', 'sticker']);

        // Chuyển đổi thành định dạng {"name": "achievement_name", "sticker": "link"}
        $result = $achievements->map(function ($achievement) {
            return [
                'name' => $achievement->name,
                'sticker' => $achievement->sticker,
            ];
        });

        return $result;
    }
}
