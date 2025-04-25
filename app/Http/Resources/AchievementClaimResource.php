<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchievementClaimResource extends JsonResource
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
            'achievement_sticker' => $this['achievement_sticker'],
            'status' => $this['status'],
        ];
    }
}
