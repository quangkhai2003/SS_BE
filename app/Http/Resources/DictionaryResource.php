<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DictionaryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'dictionary_id' => $this->dictionary_id,
            'word' => $this->word,
            'ipa' => $this->ipa,
            'word_type' => $this->word_type,
            'vietnamese' => $this->vietnamese,
            'topic' => $this->topic,
            'examples' => $this->examples,
            'examples_vietnamese' => $this->examples_vietnamese,
        ];
    }

    public static function collection($resource)
    {
        return new DictionaryCollection($resource);
    }
}

