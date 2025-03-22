<?php
namespace App\Services;

use App\Models\Level;
use App\Models\Progress;
use App\Models\Word;

class RoadMapService
{
    // Method to get lesson information based on topic and node
    public function Lesson($topic, $node){
        // Find the progress for the given topic
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
            return response()->json([
                'message' => "Topic not found: $topic",
                'status' => 'error'
            ], 404);
        }

        // Calculate level_id based on progress_id and node
        $levelId = (($progress->progress_id - 1) * 4) + $node;
        $level = Level::find($levelId);

        if (!$level) {
            return false;
        }

        // Get words associated with the level
        $words = $level->words;

        if (!$words) {
            return false;
        }

        // Prepare options for lessons
        $optionsImages = $words->pluck('image')->toArray();
        $optionsWords = $words->pluck('word')->toArray();

        // Create 4 lessons
        $lessons = [];
        $lessons[] = [
            'lesson_id' => 1,
            'type' => 'listen_and_choose_image',
            'sound' => $words[0]->sound, 
            'options' => array_values(array_rand(array_flip($optionsImages), 4)), // 4 random images
            'correct_answer' => $words[0]->image, 
        ];
        $lessons[] = [
            'lesson_id' => 2,
            'type' => 'view_image_and_choose_word',
            'image' => $words[1]->image, 
            'options' => array_values(array_rand(array_flip($optionsWords), 4)), // 4 random words
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
            'options' => array_values(array_rand(array_flip($optionsImages), 4)), // 4 random images
            'correct_answer' => $words[3]->image, 
        ];
        return $lessons;
    }

    // Method to get a specific word
    public function getWord($data)
    {
        $word = Word::where('word', $data)->first();
        if ($word) {
            return $word;
        }
        return false;
    }

    // Method to get words in a specific level based on topic and node
    public function getWordInLevel($topic, $node)
    {
        // Find the progress for the given topic
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
            return response()->json([
                'message' => "Topic not found: $topic",
                'status' => 'error'
            ], 404);
        }

        // Calculate level_id based on progress_id and node
        $levelId = (($progress->progress_id - 1) * 4) + $node;
        $level = Level::find($levelId);
        if (!$level) {
            return false;
        }

        // Get words associated with the level
        $words = $level->words;

        if (!$words) {
            return false;
        }
        return $words;
    }
}