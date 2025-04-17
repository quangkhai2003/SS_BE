<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DictionaryService;
use App\Http\Resources\DictionaryResource;
use App\Http\Requests\GetTopWordsByTopicRequest;


class DictionaryController extends Controller
{
    protected $dictionaryService;

    public function __construct(DictionaryService $dictionaryService)
    {
        $this->dictionaryService = $dictionaryService;
    }

    public function getTopWordsByTopic()
    {
    // {
        $data = $this->dictionaryService->getTopWordsByTopic();
        
        return $data;
    }
    public function getWordbyTopic(GetTopWordsByTopicRequest $request)
    {
        $topic = $request->topic;
        $words = $this->dictionaryService->getWordbyTopic($topic);

        if ($words->isEmpty()) {
            return response()->json([
                'message' => 'No words found for the given topic',
            ], 404);
        }

        return DictionaryResource::collection($words);
    }
}
