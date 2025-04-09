<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Lesson4Resource extends JsonResource
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
            'options' => $this->resource['options'],
            'correct_answer' => $this->resource['correct_answer'],
        ];
    }
}
