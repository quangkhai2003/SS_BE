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
        if (!$this->resource) {
            return [
                'message' => 'Không tìm thấy người dùng hoặc thông tin đăng nhập không đúng.',
            ];
        }
        return [
            'username' => $this->username,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'point' => $this->point,
        ];
    }
}
