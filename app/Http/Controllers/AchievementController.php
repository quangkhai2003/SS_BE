<?php

namespace App\Http\Controllers;

use App\Http\Resources\AchievementsResources;
use App\Http\Resources\CheckAchievementsResources;
use App\Http\Resources\UserStatsResource;
use App\Services\AchievementService;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    //
    protected $achievementService;
    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }
    public function getAchievements()
    {
        $achievements = $this->achievementService->getAllAchievements();
        return AchievementsResources::collection($achievements);
    }
    public function checkUserStats(Request $request)
    {
        $userStats = $this->achievementService->checkUserStats($request->bearerToken());
        return UserStatsResource::make($userStats);
    }
    public function checkAndInsertAchievements(Request $request)
    {
        $userAchievements = $this->achievementService->checkAndInsertAchievements($request->bearerToken());
        return ($userAchievements);
    }
    public function claimAchievement(Request $request)
    {
        $userAchievements = $this->achievementService->claimAchievement($request->bearerToken(), $request->achievement_id);
        return ($userAchievements);
    }
}
