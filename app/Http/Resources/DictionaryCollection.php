<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DictionaryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->all(); // Giữ nguyên cấu trúc mảng với key là topic
    }
}
    