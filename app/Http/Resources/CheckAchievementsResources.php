<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckAchievementsResources extends JsonResource
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
            'type' => $this['type'],
            'progress' => $this['progress'],
            'status' => $this['status'],
        ];
    }
}
