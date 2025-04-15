<?php
namespace App\Services;

use App\Models\Level;
use Illuminate\Support\Facades\Hash;
use App\Models\Progress;
use App\Models\User;
use App\Models\Word;
use App\Models\Your_Dictionary;
use App\Models\YourLevel;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        // Lấy tất cả các từ từ bảng Word
        $allWords = Word::all();

        if ($allWords->isEmpty()) {
            throw new \Exception('No words found');
        }

        // Trả về tất cả các từ dưới dạng collection
        return $allWords;
    }
    public function updateWord($data)
    {
        // Tìm từ dựa trên id_word
        $word = Word::find($data['id_word']);

        // Kiểm tra xem từ có tồn tại không
        if (!$word) {
            throw new \Exception('Word not found');
        }

        // Cập nhật thông tin của từ
        $word->update([
            'word' => $data['word'],
            'image' => $data['image'],
            'sound' => $data['sound'],
        ]);

        return $word;
    }

    public function CompleteLevel($token, $topic, $node)
    {
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 400);
        }

        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new AuthenticationException('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        $userId = $user->user_id;

        // Tìm progress dựa trên topic
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
            throw new \Exception('Topic not found');
        }

        // Tính toán level_id: (progress_id - 1) * 4 + node
        $levelId = (($progress->progress_id - 1) * 4) + $node;
        $level = Level::find($levelId);

        if (!$level) {
            throw new \Exception('Level not found');
        }

        // Kiểm tra xem user đã hoàn thành level trước đó chưa
        if ($node > 1) {
            $previousLevelId = (($progress->progress_id - 1) * 4) + ($node - 1);
            $previousLevel = YourLevel::where('user_id', $userId)
                ->where('level_id', $previousLevelId)
                ->first();

            if (!$previousLevel) {
                throw new \Exception('You must complete the previous level before this one');
            }
        }

        // Kiểm tra xem user đã hoàn thành level này chưa
        $existing = YourLevel::where('user_id', $userId)
            ->where('level_id', $levelId)
            ->first();

        if ($existing) {
            throw new \Exception('Level already completed by user');
        }

        // Lưu thông tin level hoàn thành vào bảng your_level
        YourLevel::create([
            'user_id' => $userId,
            'level_id' => $levelId,
        ]);
        $words = $level->words; // Lấy danh sách các từ trong level
        foreach ($words as $word) {
            // Kiểm tra xem từ đã tồn tại trong your_dictionary chưa
            $existingWord = Your_Dictionary::where('user_id', $userId)
                ->where('dictionary_id', $word->id)
                ->first();

            if (!$existingWord) {
                Your_Dictionary::create([
                    'user_id' => $userId,
                    'dictionary_id' => $word->id,
                    'created_at' => now(),
                ]);
            }
        }
        $userFresh = User::find($user->user_id);
        $userFresh->point += 10;
        $userFresh->save();

        return [
            'message' => 'Level completed successfully',
            'level_id' => $levelId,
        ];
    }

    public function CreateProgress($data)
    {
        // Kiểm tra xem topic đã tồn tại chưa
        $existingProgress = Progress::where('topic_name', $data)->first();
        if ($existingProgress) {
            throw new \Exception('Progress for this topic already exists');
        }

        // Tạo progress mới
        $progress = Progress::create([
            'topic_name' => $data
        ]);

        // Lấy level cao nhất hiện tại
        $highestLevelId = Level::max('level_id');
        $newLevelIdStart = $highestLevelId ? $highestLevelId + 1 : 1;

        // Tạo 4 level mới
        for ($i = 0; $i < 4; $i++) {
            Level::create([
                'level_id' => $newLevelIdStart + $i,
                'progress_id' => $progress->progress_id,
                'level_name' => "Level " . ($newLevelIdStart + $i),
            ]);
        }

        return $progress;
    }

    public function AddWordsToLevel($levelId, $words)
    {
        // Tìm level dựa trên level_id
        $level = Level::where('level_id', $levelId)->first();

        if (!$level) {
            throw new \Exception('Level may not be associated with any topic');
        }

        // Kiểm tra số lượng từ hiện tại trong level
        $currentWordCount = Word::where('id_level', $levelId)->count();

        if ($currentWordCount >= 4) {
            throw new \Exception('This level already has 4 words');
        }

        // Tính số từ có thể thêm vào
        $remainingSlots = 4 - $currentWordCount;

        if (count($words) > $remainingSlots) {
            throw new \Exception("You can only add $remainingSlots more word(s) to this level");
        }

        // Thêm từng từ vào level
        foreach ($words as $wordData) {
            // Kiểm tra dữ liệu từ trước khi thêm
            if (!isset($wordData['word'], $wordData['image'], $wordData['sound'])) {
                throw new \Exception('Each word must have "word", "image", and "sound" fields');
            }

            // Kiểm tra từ có tồn tại trong hệ thống hay không
            $existingWord = Word::where('word', $wordData['word'])->first();
            if ($existingWord) {
                throw new \Exception("Word '{$wordData['word']}' already exists in the system");
            }

            Word::create([
                'id_level' => $levelId,
                'word' => $wordData['word'],
                'image' => $wordData['image'],
                'sound' => $wordData['sound'],
            ]);
        }

        return [
            'message' => 'Words added successfully to the level',
            'level_id' => $levelId,
            'current_word_count' => Word::where('id_level', $levelId)->count(),
        ];
    }
    public function GetUserLevel($token)
    {
        // Kiểm tra token
        if (!$token) {
            throw new \Exception('Token not provided');
        }

        // Xác thực token và lấy thông tin user
        JWTAuth::setToken($token);
        if (!JWTAuth::check()) {
            throw new \Exception('Token is invalid or expired');
        }

        $user = JWTAuth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        $userId = $user->user_id;

        // Lấy tất cả các level mà người dùng đã hoàn thành
        $userLevels = YourLevel::where('user_id', $userId)
            ->with('level.progress') // Eager load thông tin level và progress
            ->get();

        // Kiểm tra nếu không có level nào
        if ($userLevels->isEmpty()) {
            throw new \Exception('No levels found for this user');
        }

        // Tạo danh sách các topic và node
        $levels = [];
        foreach ($userLevels as $userLevel) {
            if ($userLevel->level && $userLevel->level->progress) {
                $levelId = $userLevel->level->level_id;
                $progressId = $userLevel->level->progress->progress_id;
                $node = ($levelId - 1) % 4 + 1; // Tính node (1, 2, 3, hoặc 4)
                $topic = $userLevel->level->progress->topic_name;

                $levels[] = [
                    'topic' => $topic,
                    'node' => $node
                ];
            }
        }

        // Trả về danh sách các level
        return $levels;
    }
}