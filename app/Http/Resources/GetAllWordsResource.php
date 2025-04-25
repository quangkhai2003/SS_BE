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
            'id_word' => $this['id_word'],
            'id_level' => $this['id_level'],
            'word' => $this['word'],
            'image' => $this['image'],
            'sound' => $this['sound'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'topic' => $this['topic'],
        ];
    }
}
