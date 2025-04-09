<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Lesson1Resource extends JsonResource
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
            'sound' => $this->resource['sound'],
            'options' => $this->resource['options'],
            'correct_answer' => $this->resource['correct_answer'],
        ];
    }
}
