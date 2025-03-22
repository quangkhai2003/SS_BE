<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResgisterResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->resource['user']->username,
            'full_name' => $this->resource['user']->full_name,
            'email' => $this->resource['user']->email,
            'study_day' => $this->resource['user']->study_day,
            'created_at' => $this->resource['user']->created_at,
            'updated_at' => $this->resource['user']->updated_at,
        ];
    }
}
