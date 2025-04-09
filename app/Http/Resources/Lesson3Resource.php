<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Lesson3Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lesson_id' => $this->resource['lesson_id'],
            'type' => $this->resource['type'],
            'word' => $this->resource['word'],
            'sound' => $this->resource['sound'],
        ];
    }
}
