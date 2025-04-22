<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddWordsToLevelRequest;
use App\Http\Requests\AddWordToDictionaryRequest;
use App\Http\Requests\DictionaryRequest;
use Illuminate\Http\Request;
use App\Services\DictionaryService;
use App\Http\Resources\DictionaryResource;
use App\Http\Requests\GetTopWordsByTopicRequest;
use App\Http\Requests\updateWordInDictionaryRequest;
use PSpell\Dictionary;

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
        $data = $this->dictionaryService->getDictionary();
        return $data;
    }
    public function getWordbyToppic(GetTopWordsByTopicRequest $request)
    {
        $topic = $request->topic;
        $words = $this->dictionaryService->getWordbyToppic($topic);

        if ($words->isEmpty()) {
            return response()->json([
                'message' => 'No words found for the given topic',
            ], 404);
        }
        return DictionaryResource::collection($words);
    }
    public function addWordToYourDictionary(Request $request)
    {

        $result = $this->dictionaryService->addWordToYourDictionary($request->bearerToken(), $request->word);
        return $result;
    }
    public function getYourDictionary(Request $request)
    {
        $result = $this->dictionaryService->getYourDictionary($request->bearerToken());
        return $result;
    }
    public function getAllDictionary()
    {
        $words = $this->dictionaryService->getAllDictionary();    
        return DictionaryResource::collection($words);
    }
    public function suggestWord(Request $request)
    {
        $suggestions = $this->dictionaryService->suggestWord($request->bearerToken(), $request->topic);
        return ($suggestions);
    }
    public function AddWordToDictionary(AddWordToDictionaryRequest $request)
    {
        $result = $this->dictionaryService->AddWordToDictionary($request);
        return DictionaryResource::make($result);
    }
    public function updateWordInDictionary(updateWordInDictionaryRequest $request)
    {
        $result = $this->dictionaryService->updateWordInDictionary($request);
        return DictionaryResource::make($result);
    }

}
