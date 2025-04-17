<?php

namespace App\Services;
use App\Models\Dictionary;
use Dedoc\Scramble\Attributes\Example;

use function PHPUnit\Framework\exactly;

class DictionaryService
{        
    public function getTopWordsByTopic() {
        $topics = Dictionary::select('topic')
            ->distinct()
            ->pluck('topic');
    
        $result = [];
        foreach ($topics as $topic) {
            $words = Dictionary::where('topic', $topic)
                ->orderBy('dictionary_id', 'asc')
                ->limit(5)
                ->get(['dictionary_id', 'word', 'ipa', 'word_type', 'vietnamese', 'examples', 'examples_vietnamese', 'topic']);
    
                $result[$topic] = $words;
            }
    
        return $result;
    }
    public function getWordbyTopic(String $topic) {
        return Dictionary::where('topic', $topic)->get();
    }
}