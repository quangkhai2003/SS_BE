<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FapiResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'predictions' => PredictionResource::collection($this->resource['predictions'] ?? []),
            'processed_image' => $this->resource['processed_image'] ?? null,
        ];
    }
}