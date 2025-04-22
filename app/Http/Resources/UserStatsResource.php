<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'study_day' => $this['study_day'],
            'highest_level' => $this['highest_level'],
            'word_count' => $this['word_count'],
        ];  
    }
}
