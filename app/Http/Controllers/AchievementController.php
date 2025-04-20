<?php

namespace App\Http\Controllers;

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
    public function getAchievements(Request $request)
    {
        $achievements = $this->achievementService->getAllAchievements();
        return ($achievements);
    }
}
