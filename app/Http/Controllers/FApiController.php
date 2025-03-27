<?php

namespace App\Http\Controllers;

use App\Http\Requests\FApiRequest;
use App\Http\Resources\FApiResource;
use App\Services\FapiService;

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
}