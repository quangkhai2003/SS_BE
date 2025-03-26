<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseData = [
            'lesson_id' => $this->resource['lesson_id'],
            'type' => $this->resource['type'],
        ];

        // Dữ liệu bổ sung dựa trên type
        switch ($this->resource['type']) {
            case 'listen_and_choose_image':
                return array_merge($baseData, [
                    'sound' => $this->resource['sound'],
                    'options' => $this->resource['options'],
                    'correct_answer' => $this->resource['correct_answer'],
                ]);

            case 'view_image_and_choose_word':
                return array_merge($baseData, [
                    'image' => $this->resource['image'],
                    'options' => $this->resource['options'],
                    'correct_answer' => $this->resource['correct_answer'],
                ]);

            case 'show_word':
                return array_merge($baseData, [
                    'word' => $this->resource['word'],
                    'sound' => $this->resource['sound'],
                ]);

            case 'read_word_and_choose_image':
                return array_merge($baseData, [
                    'word' => $this->resource['word'],
                    'options' => $this->resource['options'],
                    'correct_answer' => $this->resource['correct_answer'],
                ]);

            default:
                return $baseData;
        }
    }
}
