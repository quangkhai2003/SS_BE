<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResources extends JsonResource
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
            'message' => $this['message'],
        ];
    }
    /**
     * Tạo resource từ thông báo.
     *
     * @param string $message
     * @return array<string, mixed>
     */
    public static function createMessageResource($message)
    {
        // Create a message resource array
        return [
            'message' => $message,
        ];
    }
}
