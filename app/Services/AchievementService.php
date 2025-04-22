<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\Your_Dictionary;
use App\Models\YourAchievement;
use App\Models\YourLevel;
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
            $status = 'incomplete';

            // Kiểm tra điều kiện dựa trên type
            switch ($achievement->type) {
                case 'Date':
                    $progress = $userStats['study_day'];
                    if ($progress >= $requirement) {
                        $status = 'complete';
                        $progress = $requirement; // Đảm bảo hiển thị req/req khi complete
                    }
                    break;
                case 'Level':
                    $progress = $userStats['highest_level'];
                    if ($progress >= $requirement) {
                        $status = 'complete';
                        $progress = $requirement; // Đảm bảo hiển thị req/req khi complete
                    }
                    break;
                case 'Word':
                    $progress = $userStats['word_count'];
                    if ($progress >= $requirement) {
                        $status = 'complete';
                        $progress = $requirement; // Đảm bảo hiển thị req/req khi complete
                    }
                    break;
            }
            // Kiểm tra nếu achievement đã được ghi nhận
            $exists = YourAchievement::where('user_id', $user->user_id)
                ->where('achievement_id', $achievement->achievement_id)
                ->exists();

            if (!$exists && $status === 'complete') {
                // Cộng điểm bonus_points vào point của user
                $user->increment('point', $achievement->bonus_points);

                // Thêm bản ghi vào bảng your_achievements
                YourAchievement::create([
                    'user_id' => $user->user_id,
                    'achievement_id' => $achievement->achievement_id,
                    'status' => $status,
                    'created_at' => now()->startOfDay(),
                ]);
            }

            // Thêm thông tin achievement vào kết quả
            $result[] = [
                'achievement_id' => $achievement->achievement_id,
                'name' => $achievement->name,
                'type' => $achievement->type,
                'progress' => "{$progress}/{$requirement}",
                'status' => $status,
            ];
        }

        return $result;
    }
}
