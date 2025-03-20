<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoadMapRequest;
use App\Services\RoadMapService;
use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Progress;

class RoadMapController extends Controller
{
    //
    protected $levelService;

    public function __construct(RoadMapService $levelService)
    {
        $this->levelService = $levelService;
    }
    public function GetWordInLevel(RoadMapRequest $request)
    {
        $lessonInfo = $this->levelService->GetWordInLevel($request->topic, $request->node);
        return $lessonInfo;
    }
}
