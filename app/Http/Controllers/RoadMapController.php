<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoadMapRequest;
use App\Services\RoadMapService;
use App\Http\Requests\WordRequest;
use App\Http\Resources\WordResource;
use App\Http\Requests\LevelRequest;

class RoadMapController extends Controller
{
    //
    protected $levelService;

    public function __construct(RoadMapService $levelService)
    {
        $this->levelService = $levelService;
    }
    public function Lesson(RoadMapRequest $request)
    {
        $lessonInfo = $this->levelService->Lesson($request->topic, $request->node);
        return $lessonInfo;
    }
    public function GetWord(WordRequest $request)
    {
        $word = $this->levelService->GetWord($request->word);
        return WordResource::make($word);
    }
    public function GetWordInLevel(RoadMapRequest $request)
    {
        $words = $this->levelService->getWordInLevel($request->topic, $request->node);
        return WordResource::collection($words);
    }
}
