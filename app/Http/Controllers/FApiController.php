<?php

namespace App\Http\Controllers;

use App\Http\Requests\FApiRequest;
use App\Http\Resources\FApiResource;
use App\Services\FapiService;
use Illuminate\Http\Request;

class FApiController extends Controller{

    protected $FApiservice ;

    public function __construct(FApiService $FApiService)
    {
        $this->FApiservice = $FApiService;
    }

    public function Process (FApiRequest $Request)
    {
        $result = $this->FApiservice->processAiRequest($Request->file('file'));

        return new FApiResource($result);
    }
    public function pronunciation (FApiRequest $Request)
    {
        $result = $this->FApiservice->pronunciation($Request->input('sample_sentence'), $Request->file('file'));

        return $result;
    }
    public function audio(Request $request)
    {
        $result = $this->FApiservice->audio($request->word, $request->voice);
        return $result;
    }
    public function generate(Request $request) {
        $result = $this->FApiservice->generate($request->word);
        return $result;
    }
}