<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoadMapRequest;
use App\Services\RoadMapService;
use App\Http\Requests\WordRequest;
use App\Http\Resources\WordResource;
use App\Http\Requests\LevelRequest;

class RoadMapController extends Controller
{
    // RoadMapService instance
    protected $levelService;
    // Constructor to initialize RoadMapService
    public function __construct(RoadMapService $levelService)
    {
        $this->levelService = $levelService;
    }
    // Method to get lesson information
    public function Lesson(RoadMapRequest $request)
    {
        $lessonInfo = $this->levelService->Lesson($request->topic, $request->node);
        return $lessonInfo;
    }
    // Method to get words
    public function GetWord(WordRequest $request)
    {
        $word = $this->levelService->GetWord($request->word);
        return WordResource::make($word);
    }
    // Method to get words in a specific level
    public function GetWordInLevel(RoadMapRequest $request)
    {
        $words = $this->levelService->getWordInLevel($request->topic, $request->node);
        return WordResource::collection($words);
    }
}
