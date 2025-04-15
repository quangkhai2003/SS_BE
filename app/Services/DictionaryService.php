<?php

namespace App\Services;
use App\Models\Dictionary;
use App\Models\Your_Dictionary;
use Dedoc\Scramble\Attributes\Example;
use Tymon\JWTAuth\Facades\JWTAuth;

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
    public function getWordbyToppic(String $topic) {
        return Dictionary::where('topic', $topic)->get();
    }
    public function addWordToYourDictionary($token, $word)
    {
        // Xác thực token và lấy thông tin user
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new \Exception('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Kiểm tra từ có được cung cấp hay không
        if (!$word) {
            throw new \Exception('Word is required');
        }

        // Tìm từ trong bảng Dictionary
        $dictionaryWord = Dictionary::where('word', $word)->first();
        if (!$dictionaryWord) {
            throw new \Exception('Word not found in dictionary');
        }

        // Kiểm tra xem từ đã tồn tại trong your_dictionary chưa
        $existingEntry = Your_Dictionary::where('user_id', $user->user_id)
            ->where('dictionary_id', $dictionaryWord->dictionary_id)
            ->first();

        if ($existingEntry) {
            return [
                'message' => 'Word already exists in your dictionary',
            ];
        }

        // Thêm từ vào your_dictionary
        Your_Dictionary::create([
            'user_id' => $user->user_id,
            'dictionary_id' => $dictionaryWord->dictionary_id,
            'created_at' => now(),
        ]);

        return [
            'message' => 'Word added to your dictionary successfully',
        ];
    }
    public function getYourDictionary($token)
    {
        // Xác thực token và lấy thông tin user
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new \Exception('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Lấy thông tin từ bảng your_dictionary theo user_id
        $yourDictionary = Your_Dictionary::where('user_id', $user->user_id)
        ->with(['dictionary' => function ($query) {
            $query->select('dictionary_id', 'word', 'ipa', 'word_type', 'vietnamese', 'examples', 'examples_vietnamese', 'topic') // Chỉ lấy các cột cần thiết
                ->orderBy('topic', 'asc'); // Sắp xếp theo topic
        }])
        ->get()
        ->pluck('dictionary'); // Chỉ lấy thông tin từ bảng dictionary

        // Kiểm tra nếu không có dữ liệu
        if ($yourDictionary->isEmpty()) {
            throw new \Exception('No words found in your dictionary');
        }
        $groupedByTopic = $yourDictionary->groupBy('topic');

        // Chuyển đổi dữ liệu thành định dạng mong muốn
        $result = [];
        foreach ($groupedByTopic as $topic => $words) {
            $result[$topic] = $words->map(function ($word) {
                return [
                    'dictionary_id' => $word->dictionary_id,
                    'word' => $word->word,
                    'ipa' => $word->ipa,
                    'word_type' => $word->word_type,
                    'vietnamese' => $word->vietnamese,
                    'examples' => $word->examples,
                    'examples_vietnamese' => $word->examples_vietnamese,
                    'topic' => $word->topic,
                ];
            });
        }
    
        return $result;
    }
}