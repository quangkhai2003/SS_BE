<?php
namespace App\Services;

use App\Models\Level;
use Illuminate\Support\Facades\Hash;
use App\Models\Progress;
use App\Models\Word;

class RoadMapService
{
    public function GetLesson1($topic, $node){
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
           throw new \Exception('Topic not found');
        }
        //level_id: (progress_id - 1) * 4 + node
        $levelId = (($progress->progress_id - 1) * 4) + $node;
        $level = Level::find($levelId);

        if (!$level) {
            return false;
        }

         $words = $level->words;

        if (!$words) {
            return false;
        }
        $optionsImages = $words->pluck('image')->toArray();
        $optionsWords = $words->pluck('word')->toArray();
        // Tạo 4 bài tập
        $lessons = [];
        $lessons[] = [
            'lesson_id' => 1,
            'type' => 'listen_and_choose_image',
            'sound' => $words[0]->sound, 
            'options' => array_values(array_rand(array_flip($optionsImages), 4)), // 4 hình ngẫu nhiên
            'correct_answer' => $words[0]->image, 
        ];
        return $lessons;
    }
    public function GetLesson2($topic, $node){
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
            throw new \Exception('Topic not found');
        }
        //level_id: (progress_id - 1) * 4 + node
        $levelId = (($progress->progress_id - 1) * 4) + $node;
        $level = Level::find($levelId);

        if (!$level) {
            return false;
        }

         $words = $level->words;

        if (!$words) {
            return false;
        }
        $optionsImages = $words->pluck('image')->toArray();
        $optionsWords = $words->pluck('word')->toArray();
        // Tạo 4 bài tập
        $lessons = [];
        $lessons[] = [
            'lesson_id' => 2,
            'type' => 'view_image_and_choose_word',
            'image' => $words[1]->image, 
            'options' => array_values(array_rand(array_flip($optionsWords), 4)), // 4 từ ngẫu nhiên
            'correct_answer' => $words[1]->word, 
        ];
        return $lessons;
    }
    public function GetLesson3($topic, $node){
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
           throw new \Exception('Topic not found');
        }
        //level_id: (progress_id - 1) * 4 + node
        $levelId = (($progress->progress_id - 1) * 4) + $node;
        $level = Level::find($levelId);

        if (!$level) {
            return false;
        }

         $words = $level->words;

        if (!$words) {
            return false;
        }
        $optionsImages = $words->pluck('image')->toArray();
        $optionsWords = $words->pluck('word')->toArray();
        // Tạo 4 bài tập
        $lessons = [];
        $lessons[] = [
            'lesson_id' => 3,
            'type' => 'show_word',
            'word' => $words[2]->word, 
            'sound' => $words[2]->sound,
        ];
        return $lessons;
    }
    public function GetLesson4($topic, $node){
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
           throw new \Exception('Topic not found');
        }
        //level_id: (progress_id - 1) * 4 + node
        $levelId = (($progress->progress_id - 1) * 4) + $node;
        $level = Level::find($levelId);

        if (!$level) {
            return false;
        }

         $words = $level->words;

        if (!$words) {
            return false;
        }
        $optionsImages = $words->pluck('image')->toArray();
        $optionsWords = $words->pluck('word')->toArray();
        // Tạo 4 bài tập
        $lessons = [];
        $lessons[] = [
            'lesson_id' => 4,
            'type' => 'read_word_and_choose_image',
            'word' => $words[3]->word, 
            'options' => array_values(array_rand(array_flip($optionsImages), 4)), // 4 hình ngẫu nhiên
            'correct_answer' => $words[3]->image, 
        ];
        return $lessons;
    }
    public function GetWordLevel($topic, $node){
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
           throw new \Exception('Topic not found');
        }
        //level_id: (progress_id - 1) * 4 + node
        $levelId = (($progress->progress_id - 1) * 4) + $node;
        $level = Level::find($levelId);

        if (!$level) {
            return false;
        }

         $words = $level->words;

        if (!$words) {
            return false;
        }
        return $words;
    }
    public function GetWordTopic($topic){
         // Find the progress for the given topic
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
            throw new \Exception('Topic not found');
        }

        $allWords = collect(); // Use a collection to store words

        // Each topic has 4 levels, iterate through each node (1 to 4)
        for ($node = 1; $node <= 4; $node++) {
            // Calculate levelId: (progress_id - 1) * 4 + node
            $levelId = (($progress->progress_id - 1) * 4) + $node;
            $level = Level::find($levelId);

            if (!$level) {
                continue; // Skip to the next node if the level is not found
            }

            // Get words associated with the level
            $words = $level->words;
            if ($words) {
                // Merge all words of this level into the collection
                $allWords = $allWords->merge($words);
            }
        }

        if ($allWords->isEmpty()) {
            throw new \Exception('No words found for this topic');
        }

        // Return all words as a collection
        return $allWords;
    }

    public function GetWord($word)
    {
        // Tìm từ trong cơ sở dữ liệu
        $wordInfo = Word::where('word', $word)->first();

        // Kiểm tra xem từ có tồn tại không
        if (!$wordInfo) {
            throw new \Exception('Word not found');
        }

        // Trả về thông tin của từ
        return $wordInfo;
    }
    public function GetAllWords()
    {
        // Lấy tất cả các progress (tương ứng với các topic)
        $allProgress = Progress::all();

        if ($allProgress->isEmpty()) {
            throw new \Exception('No topics found');
        }

        $allWords = collect(); // Sử dụng collection để lưu trữ tất cả các từ

        // Lặp qua từng progress (topic)
        foreach ($allProgress as $progress) {
            // Mỗi topic có 4 levels, lặp qua từng node (1 đến 4)
            for ($node = 1; $node <= 4; $node++) {
                // Tính toán levelId: (progress_id - 1) * 4 + node
                $levelId = (($progress->progress_id - 1) * 4) + $node;
                $level = Level::find($levelId);

                if (!$level) {
                    continue; // Bỏ qua nếu level không tồn tại
                }

                // Lấy các từ liên kết với level
                $words = $level->words;
                if ($words) {
                    // Gộp tất cả các từ của level vào collection
                    $allWords = $allWords->merge($words);
                }
            }
        }

        if ($allWords->isEmpty()) {
            throw new \Exception('No words found');
        }

        // Trả về tất cả các từ dưới dạng collection
        return $allWords;
    }

    public function updateWord($data)
    {
        $word = Word::where('word', $data['word'])->first();

        // Kiểm tra xem từ có tồn tại không
        if (!$word) {
            throw new \Exception('Word not found');
        }
      
        $word->update([
            'image' => $data['image'],
            'sound' => $data['sound'],
        ]);
        return $word;
    }
}