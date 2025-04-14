<?php

namespace App\Services;
use App\Models\Dictionary;
use Dedoc\Scramble\Attributes\Example;

use function PHPUnit\Framework\exactly;

class DictionaryService
{        
    public function getDictionary() {
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
    public function getWordsByTopic($topic)
    {
        // Lấy tất cả các từ trong topic được chỉ định
        $words = Dictionary::where('topic', $topic)
            ->orderBy('dictionary_id', 'asc')
            ->get(['dictionary_id', 'word', 'ipa', 'word_type', 'vietnamese', 'examples', 'examples_vietnamese', 'topic']);

        // Kiểm tra nếu không có từ nào trong topic
        if ($words->isEmpty()) {
            throw new \Exception("No words found for the topic: $topic");
        }
        return $words;
    }
}