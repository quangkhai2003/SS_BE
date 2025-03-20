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

        $user = $this->resource['user'];


        $data = [
            'username' => $this->$user->username,
            'full_name' => $this->$user->full_name,
            'email' => $this->$user->email,
            'study_day' => $this->$user->study_day,
            'created_at' => $this->$user->created_at,
            'updated_at' => $this->$user->updated_at,
        ];

        return $data;
    }
}
