<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return 
        [
            'user_id' => $this['user_id'],
            'username' => $this['username'],
            'email' => $this['email'],
            'point' => $this['point'],
            'role' => $this['role'],
            'study_day' => $this['study_day'],
            'last_login_at' => $this['last_login_at'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
        ];
    }
}
