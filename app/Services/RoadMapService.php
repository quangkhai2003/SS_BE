<?php
namespace App\Services;

use App\Models\Level;
use Illuminate\Support\Facades\Hash;
use App\Models\Progress;

class RoadMapService
{
    public function GetWordInLevel($topic, $node){
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
            return response()->json([
                'message' => "Không tìm thấy topic: $topic",
                'status' => 'error'
            ], 404);
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
        $lessons[] = [
            'lesson_id' => 2,
            'type' => 'view_image_and_choose_word',
            'image' => $words[1]->image, 
            'options' => array_values(array_rand(array_flip($optionsWords), 4)), // 4 từ ngẫu nhiên
            'correct_answer' => $words[1]->word, 
        ];
        $lessons[] = [
            'lesson_id' => 3,
            'type' => 'show_word',
            'word' => $words[2]->word, 
            'sound' => $words[2]->sound,
        ];
        $lessons[] = [
            'lesson_id' => 4,
            'type' => 'read_word_and_choose_image',
            'word' => $words[3]->word, 
            'options' => array_values(array_rand(array_flip($optionsImages), 4)), // 4 hình ngẫu nhiên
            'correct_answer' => $words[3]->image, 
        ];
        return $lessons;
    }
}