<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResourse extends JsonResource
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
            'point' => $this->resource['user']->point,
        ];
    }
}
