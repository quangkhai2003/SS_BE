<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\FApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RoadMapController;
use App\Services\AdminService;
use PSpell\Dictionary;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



//below is the route for user
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    // AuthController
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('checkrole:User');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('checkrole:User');
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('checkrole:User|Guest');
    Route::get('/leaderboard', [AuthController::class, 'getLeaderboard']);

    // RoadMapController
    Route::post('/getLesson1', [RoadMapController::class, 'GetLesson1']);
    Route::post('/getLesson2', [RoadMapController::class, 'GetLesson2']);
    Route::post('/getLesson3', [RoadMapController::class, 'GetLesson3']);
    Route::post('/getLesson4', [RoadMapController::class, 'GetLesson4']);
    Route::post('/getWordLevel', [RoadMapController::class, 'GetWordLevel']);
    Route::post('/getWordTopic', [RoadMapController::class, 'GetWordTopic']);
    Route::post('/getWord', [RoadMapController::class, 'GetWord']);
    Route::post('/completeLevel', [RoadMapController::class, 'completeLevel'])->middleware('checkrole:User|Guest');
    Route::post('/getUserLevel', [RoadMapController::class, 'GetUserLevel'])->middleware('checkrole:User|Guest');
    Route::post('/getUserHighestLevel', [RoadMapController::class, 'GetUserHighestLevel'])->middleware('checkrole:User|Guest');
    Route::post('/openMysteryChest', [RoadMapController::class, 'OpenMysteryChest'])->middleware('checkrole:User|Guest');

    // GuestController
    Route::post('/loginGuest', [GuestController::class, 'loginGuest']);
    Route::post('/logoutGuest', [GuestController::class, 'logoutGuest'])->middleware('checkrole:Guest');
    Route::post('/upgradeGuest', [GuestController::class, 'upgradeGuest'])->middleware('checkrole:Guest');

    // FApiController
    Route::post('/FApidetection', [FApiController::class, 'Process'])->middleware('checkrole:User');
    Route::post('/pronunciation', [FApiController::class, 'pronunciation']);
    Route::post('/audio', [FApiController::class, 'audio']);
    Route::post('/generate', [FApiController::class, 'generate']);

    // DictionaryController
    Route::get('/getDictionary', [DictionaryController::class, 'getTopWordsByTopic']);
    Route::post('/getWordbyToppic', [DictionaryController::class, 'getWordbyToppic']);
    Route::post('/getUserLevel', [RoadMapController::class, 'GetUserLevel'])->middleware('checkrole:User');
    Route::post('/GetUserHighestLevel', [RoadMapController::class, 'GetUserHighestLevel'])->middleware('checkrole:User');
    Route::post('/addWordToYourDictionary', [DictionaryController::class, 'addWordToYourDictionary'])->middleware('checkrole:User');
    Route::get('/getYourDictionary', [DictionaryController::class, 'getYourDictionary'])->middleware('checkrole:User');
    Route::post('/addWordToYourDictionaryGuest', [DictionaryController::class, 'addWordToYourDictionary'])->middleware('checkrole:Guest');
    Route::get('/getYourDictionaryGuest', [DictionaryController::class, 'getYourDictionary'])->middleware('checkrole:Guest');
    Route::post('/suggestWord', [DictionaryController::class, 'suggestWord'])->middleware('checkrole:User|Guest');

    // AchievementController
    Route::get('/getAchievements', [AchievementController::class, 'getAchievements']);
    Route::get('/checkUserStats', [AchievementController::class, 'checkUserStats'])->middleware('checkrole:User|Guest');
    Route::get('/checkAndInsertAchievements', [AchievementController::class, 'checkAndInsertAchievements'])->middleware('checkrole:User|Guest');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'admin',
    // below is the route for admin
], function ($router) {
    // AdminController
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->middleware('checkrole:Admin');
    Route::post('/getUser', [AdminController::class, 'getUser'])->middleware('checkrole:Admin');
    Route::get('/getAllUser', [AdminController::class, 'getAllUser'])->middleware('checkrole:Admin');
    Route::post('/getUsersByRole', [AdminController::class, 'getUsersByRole'])->middleware('checkrole:Admin');
    Route::delete('/deleteUser', [AdminController::class, 'deleteUser'])->middleware('checkrole:Admin');
    Route::put('/updateUser', [AdminController::class, 'updateUser'])->middleware('checkrole:Admin');
    Route::post('/addUser', [AdminController::class, 'AddUser'])->middleware('checkrole:Admin');

    // AuthController
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('checkrole:Admin');
    
    // FApiController
    Route::post('/FApidetection', [FApiController::class, 'Process'])->middleware('checkrole:Admin');

    // RoadMapController
    Route::post('/updateWord', [RoadMapController::class, 'UpdateWord'])->middleware('checkrole:Admin');
    Route::get('/getAllWords', [RoadMapController::class, 'GetAllWords'])->middleware('checkrole:Admin');
    Route::post('/createProgress', [RoadMapController::class, 'CreateProgress'])->middleware('checkrole:Admin');
    Route::post('/addWordsToLevel', [RoadMapController::class, 'AddWordsToLevel'])->middleware('checkrole:Admin');

    // DictionaryController
    Route::get('/getAllDictionary', [DictionaryController::class, 'getAllDictionary'])->middleware('checkrole:Admin');
    Route::post('/addWordToDictionary', [DictionaryController::class, 'AddWordToDictionary'])->middleware('checkrole:Admin');
    Route::put('/updateWordInDictionary', [DictionaryController::class, 'updateWordInDictionary'])->middleware('checkrole:Admin');
});
