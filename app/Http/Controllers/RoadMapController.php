<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoadMapRequest;
use App\Http\Resources\LessonResource;
use App\Services\RoadMapService;


class RoadMapController extends Controller
{
    //
    protected $levelService;

    public function __construct(RoadMapService $levelService)
    {
        $this->levelService = $levelService;
    }
    public function GetLesson(RoadMapRequest $request)
    {
        $lessonInfo = $this->levelService->GetLesson($request->topic, $request->node);
        return LessonResource::collection($lessonInfo);
    }
}
