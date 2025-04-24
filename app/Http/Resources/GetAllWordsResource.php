<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAllWordsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'word' => $this['word'],
            'image' => $this['image'],
            'sound' => $this['sound'],
            'level_id' => $this['level_id'], // Lấy id level nếu tồn tại
            'topic' => $this['topic'], // Lấy tên topic nếu tồn tại
        ];
    }
}
