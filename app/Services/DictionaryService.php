<?php

namespace App\Services;

use App\Models\Dictionary;
use App\Models\Your_Dictionary;
use Dedoc\Scramble\Attributes\Example;
use Tymon\JWTAuth\Facades\JWTAuth;

use function PHPUnit\Framework\exactly;

class DictionaryService
{
    public function getDictionary()
    {
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
    public function getWordbyToppic(String $topic)
    {
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
    public function getAllDictionary()
    {
        // Lấy toàn bộ dữ liệu từ bảng dictionary
        return Dictionary::all();
    }
    public function suggestWord($token, $topic)
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

        // Lấy danh sách các từ đã có trong your_dictionary của user
        $userDictionaryIds = Your_Dictionary::where('user_id', $user->user_id)
            ->pluck('dictionary_id')
            ->toArray();

        // Lấy một từ mới trong topic được chọn mà chưa có trong your_dictionary
        $suggestedWord = Dictionary::where('topic', $topic)
            ->whereNotIn('dictionary_id', $userDictionaryIds) // Loại bỏ các từ đã có
            ->first(['dictionary_id', 'word', 'ipa', 'word_type', 'vietnamese', 'examples', 'examples_vietnamese', 'topic']);

        // Kiểm tra nếu không có từ nào để gợi ý
        if (!$suggestedWord) {
            throw new \Exception('No new words to suggest for this topic');
        }

        return $suggestedWord;
    }
    public function AddWordToDictionary($data)
    {
        // Kiểm tra xem từ đã tồn tại trong bảng Dictionary chưa
        $existingWord = Dictionary::where('word', $data['word'])
            ->where('topic', $data['topic'])
            ->first();

        if ($existingWord) {
            throw new \Exception('Word already exists in the dictionary for this topic');
        }

        // Thêm từ mới vào bảng Dictionary
        $newWord = Dictionary::create([
            'word' => $data['word'],
            'ipa' => $data['ipa'],
            'word_type' => $data['word_type'],
            'vietnamese' => $data['vietnamese'],
            'examples' => $data['examples'] ?? null, // Giá trị mặc định là null nếu không có
            'examples_vietnamese' => $data['examples_vietnamese'] ?? null, // Giá trị mặc định là null nếu không có
            'topic' => $data['topic'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return $newWord;
    }
    public function updateWordInDictionary($data)
    {
        // Tìm từ trong bảng Dictionary theo ID
        $word = Dictionary::find($data['dictionary_id']);

        if (!$word) {
            throw new \Exception('Word not found in the dictionary');
        }

        // Cập nhật thông tin từ
        $word->update([
            'word' => $data['word'] ?? $word->word,
            'ipa' => $data['ipa'] ?? $word->ipa,
            'word_type' => $data['word_type'] ?? $word->word_type,
            'vietnamese' => $data['vietnamese'] ?? $word->vietnamese,
            'examples' => $data['examples'] ?? $word->examples,
            'examples_vietnamese' => $data['examples_vietnamese'] ?? $word->examples_vietnamese,
            'topic' => $data['topic'] ?? $word->topic,
            'updated_at' => now(),
        ]);

        return $word;
    }
}
