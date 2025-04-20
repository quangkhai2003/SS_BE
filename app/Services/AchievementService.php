<?php

namespace App\Services;

use App\Models\Achievement;

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
}