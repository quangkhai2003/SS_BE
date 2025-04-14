<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoadMapRequest;
use App\Http\Requests\WordRequest;
use App\Http\Requests\WordUpdateRequest;
use App\Http\Resources\Lesson1Resource;
use App\Http\Resources\Lesson2Resource;
use App\Http\Resources\Lesson3Resource;
use App\Http\Resources\Lesson4Resource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\WordResource;
use App\Services\RoadMapService;
use Illuminate\Http\Request;

class RoadMapController extends Controller
{
    //
    protected $levelService;

    public function __construct(RoadMapService $levelService)
    {
        $this->levelService = $levelService;
    }
    public function GetLesson1(RoadMapRequest $request)
    {
        $lessonInfo = $this->levelService->GetLesson1($request->topic, $request->node);
        return Lesson1Resource::collection($lessonInfo);
    }
    public function GetLesson2(RoadMapRequest $request)
    {
        $lessonInfo = $this->levelService->GetLesson2($request->topic, $request->node);
        return Lesson2Resource::collection($lessonInfo);
    }
    public function GetLesson3(RoadMapRequest $request)
    {
        $lessonInfo = $this->levelService->GetLesson3($request->topic, $request->node);
        return Lesson3Resource::collection($lessonInfo);
    }
    public function GetLesson4(RoadMapRequest $request)
    {
        $lessonInfo = $this->levelService->GetLesson4($request->topic, $request->node);
        return Lesson4Resource::collection($lessonInfo);
    }
    public function GetWordLevel(RoadMapRequest $request)
    {
        $WordInfo = $this->levelService->GetWordLevel($request->topic, $request->node);
        return WordResource::collection($WordInfo);
    }
    public function GetWordTopic(Request $request)
    {
        $WordInfo = $this->levelService->GetWordTopic($request->topic);
        return WordResource::collection($WordInfo);
    }
    public function GetAllWords()
    {
        $Words = $this->levelService->GetAllWords();
        return WordResource::collection($Words);
    }
    public function GetWord(Request $request)
    {
        $Word = $this->levelService->GetWord($request->word);
        return WordResource::make($Word);
    }
    public function UpdateWord(WordUpdateRequest $request)
    {
        $WordNew = $this->levelService->UpdateWord($request->validated());
        return WordResource::make($WordNew);
    }
    public function completeLevel(RoadMapRequest $request)
    {
        $result = $this->levelService->CompleteLevel($request->bearerToken(), $request->topic, $request->node);
        return $result;
    }
    public function CreateProgress(Request $request)
    {
        $result = $this->levelService->CreateProgress($request->topic);
        return $result;
    }
    public function AddWordsToLevel(Request $request)
    {
        $result = $this->levelService->AddWordsToLevel($request->levelId, $request->words);
        return $result;
    }
}
