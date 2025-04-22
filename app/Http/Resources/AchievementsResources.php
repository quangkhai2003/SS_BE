<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchievementsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'achievement_id' => $this['achievement_id'],
            'name' => $this['name'],
            'requirement' => $this['requirement'],
            'sticker' => $this['sticker'],
            'type' => $this['type'],
            'bonus_points' => $this['bonus_points'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
        ];
    }
}
