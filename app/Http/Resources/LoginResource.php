<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
       
    
        return [
            'access_token' => $this['access_token'], // Truy cập như mảng
            'refresh_token' => $this['refresh_token'],
        ];   
    }
}
