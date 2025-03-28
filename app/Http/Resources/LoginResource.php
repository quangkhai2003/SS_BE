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
        // if ($this->resource instanceof \Illuminate\Http\JsonResponse) {
        //     // Lấy dữ liệu từ JSON response
        //     $data = $this->resource->getData(true);
            
        //     return [
        //         'message' => $data['message'] ?? null,
        //         'user' => $data['user'] ?? null,
        //         'token_type' => $data['token_type'] ?? 'bearer',
        //         'expires_in' => $data['expires_in'] ?? null,
        //     ];
        // }
        
        // // Nếu dữ liệu đã là mảng
        // return [
        //     'message' => $this['message'] ?? 'Login successful',
        //     'user' => $this['user'] ?? null,
        //     'token_type' => $this['token_type'] ?? 'bearer',
        //     'expires_in' => $this['expires_in'] ?? null,
        // ];
    
        // return [
        //     'access_token' => $this['access_token'], // Truy cập như mảng
        //     'refresh_token' => $this['refresh_token'],
        // ];
        return [
            'message' => $this['message'] ?? 'Login successful',
        ] ;
    }
}
