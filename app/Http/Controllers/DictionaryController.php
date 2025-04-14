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
        $data = $this->dictionaryService->getDictionary();
        return $data;
    }
}
