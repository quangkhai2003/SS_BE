<?php

namespace App\Services;

use App\Models\Dictionary;
use App\Models\Level;
use Illuminate\Support\Facades\Hash;
use App\Models\Progress;
use App\Models\User;
use App\Models\UserChest;
use App\Models\Word;
use App\Models\Your_Dictionary;
use App\Models\YourLevel;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoadMapService
{
    public function GetLesson1($topic, $node)
    {
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

        // Lấy danh sách hình ảnh từ các từ
        $optionsImages = $words->pluck('image')->toArray();

        // Trộn ngẫu nhiên mảng hình ảnh
        shuffle($optionsImages);

        // Lấy 4 hình ảnh ngẫu nhiên
        $options = array_slice($optionsImages, 0, 4);

        // Đảm bảo trộn lại vị trí của các options
        shuffle($options);

        // Tạo bài tập
        $lessons = [];
        $lessons[] = [
            'lesson_id' => 1,
            'type' => 'listen_and_choose_image',
            'sound' => $words[0]->sound,
            'options' => $options, // Các hình ảnh đã được trộn
            'correct_answer' => $words[0]->image,
        ];

        return $lessons;
    }
    public function GetLesson2($topic, $node)
    {
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
        // Lấy danh sách từ và hình ảnh
        $optionsWords = $words->pluck('word')->toArray();

        // Trộn ngẫu nhiên mảng từ
        shuffle($optionsWords);

        // Lấy 4 từ ngẫu nhiên
        $options = array_slice($optionsWords, 0, 4);

        // Đảm bảo trộn lại vị trí của các options
        shuffle($options);

        // Tạo bài tập
        $lessons = [];
        $lessons[] = [
            'lesson_id' => 2,
            'type' => 'view_image_and_choose_word',
            'image' => $words[1]->image, // Hình ảnh của từ cần đoán
            'options' => $options, // Các từ đã được trộn
            'correct_answer' => $words[1]->word, // Đáp án đúng
        ];

        return $lessons;
    }
    public function GetLesson3($topic, $node)
    {
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
    public function GetLesson4($topic, $node)
    {
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
        // Lấy danh sách hình ảnh từ các từ
        $optionsImages = $words->pluck('image')->toArray();

        // Trộn ngẫu nhiên mảng hình ảnh
        shuffle($optionsImages);

        // Lấy 4 hình ảnh ngẫu nhiên
        $options = array_slice($optionsImages, 0, 4);

        // Đảm bảo trộn lại vị trí của các options
        shuffle($options);

        // Tạo bài tập
        $lessons = [];
        $lessons[] = [
            'lesson_id' => 4,
            'type' => 'read_word_and_choose_image',
            'word' => $words[3]->word, // Từ cần đoán
            'options' => $options, // Các hình ảnh đã được trộn
            'correct_answer' => $words[3]->image, // Đáp án đúng
        ];

        return $lessons;
    }
    public function GetWordLevel($topic, $node)
    {
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
    public function GetWordTopic($topic)
    {
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
        // Lấy tất cả các từ từ bảng Word cùng với thông tin topic
        $allWords = Word::with('level.progress')->get();

        if ($allWords->isEmpty()) {
            throw new \Exception('No words found');
        }

        // Định dạng dữ liệu trả về
        $result = $allWords->map(function ($word) {
            return [
                'word' => $word->word,
                'image' => $word->image,
                'sound' => $word->sound,
                'level_id' => $word->level->level_id, // Lấy id level
                'topic' => $word->level->progress->topic_name, // Lấy tên topic
            ];
        });

        return $result;
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

        // Kiểm tra xem user đã hoàn thành tất cả các level của topic trước đó (nếu có)
        if ($progress->progress_id > 1) {
            $previousTopicProgress = Progress::where('progress_id', $progress->progress_id - 1)->first();
            if ($previousTopicProgress) {
                // Tính toán level_id cuối của topic trước đó
                $lastLevelOfPreviousTopic = ($previousTopicProgress->progress_id - 1) * 4 + 4;
                $completedLevels = YourLevel::where('user_id', $userId)
                    ->where('level_id', '<=', $lastLevelOfPreviousTopic)
                    ->where('level_id', '>=', ($previousTopicProgress->progress_id - 1) * 4 + 1)
                    ->pluck('level_id')
                    ->toArray();

                // Kiểm tra xem tất cả 4 level của topic trước đã hoàn thành chưa
                for ($i = ($previousTopicProgress->progress_id - 1) * 4 + 1; $i <= $lastLevelOfPreviousTopic; $i++) {
                    if (!in_array($i, $completedLevels)) {
                        throw new \Exception('You must complete all levels of the previous topic before starting this one');
                    }
                }
            }
        }

        // Kiểm tra xem user đã hoàn thành level trước đó trong cùng topic (nếu node > 1)
        if ($node > 1) {
            $previousLevels = YourLevel::where('user_id', $userId)
                ->where('level_id', $levelId - 1)
                ->pluck('level_id')
                ->toArray();

            if (!in_array($levelId - 1, $previousLevels)) {
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

        // Thêm các từ trong level vào bảng your_dictionary
        $words = $level->words; // Lấy danh sách các từ trong level
        foreach ($words as $word) {
            // Tìm từ trong bảng dictionary dựa trên word
            $dictionaryWord = Dictionary::where('word', $word->word)->first();

            if (!$dictionaryWord) {
                throw new \Exception("Word '{$word->word}' not found in dictionary");
            }

            // Kiểm tra xem từ đã tồn tại trong your_dictionary chưa
            $existingWord = Your_Dictionary::where('user_id', $userId)
                ->where('dictionary_id', $dictionaryWord->dictionary_id)
                ->first();

            if (!$existingWord) {
                Your_Dictionary::create([
                    'user_id' => $userId,
                    'dictionary_id' => $dictionaryWord->dictionary_id,
                    'created_at' => now(),
                ]);
            }
        }

        // Cập nhật điểm cho người dùng
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
        $existingProgress = Progress::where('topic_name', $data['topic_name'])->first();
        if ($existingProgress) {
            throw new \Exception('Progress for this topic already exists');
        }

        // Tạo progress mới
        $progress = Progress::create([
            'topic_name' => $data['topic_name'],
            'created_at' => now(),
            'updated_at' => now(),
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
    public function updateProgress($data)
    {
        // Tìm progress dựa trên progress_id
        $progress = Progress::find($data['progress_id']);

        // Kiểm tra xem progress có tồn tại không
        if (!$progress) {
            throw new \Exception('Progress not found');
        }

        // Cập nhật thông tin progress
        $progress->update([
            'topic_name' => $data['topic_name'] ?? $progress->topic_name,
            'updated_at' => now(),
        ]);

        return $progress;
    }
    public function AddWordsToLevel($data)
    {
        // Tìm level dựa trên level_id
        $level = Level::where('level_id', $data['id_level'])->first();

        if (!$level) {
            throw new \Exception('Level may not be associated with any topic');
        }

        // Kiểm tra số lượng từ hiện tại trong level
        $currentWordCount = Word::where('id_level', $data['id_level'])->count();

        if ($currentWordCount >= 4) {
            throw new \Exception('This level already has 4 words');
        }

        // Tính số từ có thể thêm vào
        $remainingSlots = 4 - $currentWordCount;

        if (count($data['words']) > $remainingSlots) {
            throw new \Exception("You can only add $remainingSlots more word(s) to this level");
        }

        // Thêm từng từ vào level
        foreach ($data['words'] as $wordData) {
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
                'id_level' => $data['id_level'],
                'word' => $wordData['word'],
                'image' => $wordData['image'],
                'sound' => $wordData['sound'],
            ]);
        }

        return [
            'message' => 'Words added successfully to the level',
            'id_level' => $data['id_level']
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
    public function GetUserHighestLevel($token)
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

        $userId = $user->user_id;

        // Lấy level cao nhất mà người dùng đã hoàn thành
        $lastLevel = YourLevel::where('user_id', $userId)
            ->with('level.progress') // Eager load thông tin level và progress
            ->orderBy('level_id', 'desc') // Sắp xếp giảm dần theo level_id
            ->first();

        // Nếu không có level nào, trả về level đầu tiên
        if (!$lastLevel) {
            $firstProgress = Progress::orderBy('progress_id', 'asc')->first();
            if (!$firstProgress) {
                throw new \Exception('No progress found in the system');
            }

            return [
                'topic' => $firstProgress->topic_name,
                'node' => 1, // Bắt đầu từ node đầu tiên
            ];
        }

        // Tính toán level tiếp theo
        $levelId = $lastLevel->level->level_id + 1; // Level cao nhất +1
        $nextLevel = Level::where('level_id', $levelId)->with('progress')->first();

        // Kiểm tra nếu level tiếp theo không tồn tại
        if (!$nextLevel) {
            throw new \Exception('No next level available');
        }

        // Tính toán topic và node của level tiếp theo
        $node = ($levelId - 1) % 4 + 1; // Tính node (1, 2, 3, hoặc 4)
        $topic = $nextLevel->progress->topic_name;

        // Trả về topic và node của level tiếp theo
        return [
            'topic' => $topic,
            'node' => $node,
        ];
    }
    public function OpenMysteryChest($token, $topic)
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

        // Tìm progress dựa trên topic
        $progress = Progress::where('topic_name', $topic)->first();
        if (!$progress) {
            throw new \Exception('Topic not found');
        }

        // Kiểm tra xem user đã hoàn thành tất cả 4 level của topic chưa
        $completedLevels = YourLevel::where('user_id', $user->user_id)
            ->where('level_id', '>=', ($progress->progress_id - 1) * 4 + 1)
            ->where('level_id', '<=', ($progress->progress_id - 1) * 4 + 4)
            ->pluck('level_id')
            ->toArray();

        if (count($completedLevels) < 4) {
            throw new \Exception('You must complete all 4 levels of this topic before opening the mystery chest');
        }

        // Kiểm tra xem rương đã tồn tại chưa
        $userChest = UserChest::where('user_id', $user->user_id)
            ->where('progress_id', $progress->progress_id)
            ->first();

        // Nếu rương chưa tồn tại, tạo mới
        if (!$userChest) {
            $userChest = UserChest::create([
                'user_id' => $user->user_id,
                'progress_id' => $progress->progress_id,
            ]);
        }

        // Kiểm tra xem rương đã được mở chưa
        if ($userChest->opened_at) {
            throw new \Exception('Mystery chest for this topic has already been opened');
        }

        // Đánh dấu rương là đã mở
        $userChest->opened_at = now();
        $userChest->save();

        // Tăng 50 điểm cho người dùng
        $user->point += 50;
        $user->save();

        return [
            'message' => 'You have opened the mystery chest and earned 50 points!',
        ];
    }
}
