<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PredictionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'width' => $this->resource['width'] ?? null,
            'height' => $this->resource['height'] ?? null,
            'x' => $this->resource['x'] ?? null,
            'y' => $this->resource['y'] ?? null,
            'label' => $this->resource['label'] ?? null,
            'label_vi' => $this->resource['label_vi'] ?? null,
            'audio_path' => $this->resource['audio_path'] ?? null,
            'confidence' => $this->resource['confidence'] ?? null,
        ];
    }
}
