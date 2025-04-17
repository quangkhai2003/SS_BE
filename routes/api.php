<?php

use App\Http\Controllers\FApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RoadMapController;
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
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('checkrole:User');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('checkrole:User');
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('checkrole:User');
    Route::post('/getLesson1', [RoadMapController::class,'GetLesson1']);
    Route::post('/getLesson2', [RoadMapController::class,'GetLesson2']);
    Route::post('/getLesson3', [RoadMapController::class,'GetLesson3']);
    Route::post('/getLesson4', [RoadMapController::class,'GetLesson4']);
    Route::post('/getWordLevel', [RoadMapController::class,'GetWordLevel']);
    Route::post('/getWordTopic', [RoadMapController::class,'GetWordTopic']);
    Route::get('/getAllWords', [RoadMapController::class,'GetAllWords']);
    Route::post('/getWord', [RoadMapController::class,'GetWord']);
    Route::post('/completeLevel', [RoadMapController::class,'completeLevel'])->middleware('checkrole:User');
    Route::post('/loginGuest', [GuestController::class, 'loginGuest']);
    Route::post('/logoutGuest', [GuestController::class, 'logoutGuest'])->middleware('checkrole:Guest');
    Route::post('/upgradeGuest', [GuestController::class, 'upgradeGuest'])->middleware('checkrole:Guest');
    Route::post('/FApidetection',[FApiController::class,'Process'])->middleware('checkrole:User');
    Route::get('/leaderboard', [AuthController::class, 'getLeaderboard']);
    Route::post('/pronunciation',[FApiController::class,'pronunciation']);
    Route::post('/audio',[FApiController::class,'audio']);  
    Route::post('/generate',[FApiController::class,'generate']);
    Route::get('/getDictionary', [DictionaryController::class, 'getTopWordsByTopic']);
    Route::post('/getWordbyToppic', [DictionaryController::class, 'getWordbyToppic']);
    Route::post('/getUserLevel', [RoadMapController::class, 'GetUserLevel'])->middleware('checkrole:User');
    Route::post('/addWordToYourDictionary', [DictionaryController::class, 'addWordToYourDictionary'])->middleware('checkrole:User');
    Route::get('/getYourDictionary', [DictionaryController::class, 'getYourDictionary'])->middleware('checkrole:User');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'admin',
// below is the route for admin
], function ($router) {
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->middleware('checkrole:Admin');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('checkrole:Admin');
    Route::post('/getUser', [AdminController::class, 'getUser'])->middleware('checkrole:Admin');
    Route::get('/getAllUser', [AdminController::class, 'getAllUser'])->middleware('checkrole:Admin');
    Route::post('/getUsersByRole', [AdminController::class, 'getUsersByRole'])->middleware('checkrole:Admin');
    Route::post('/deleteByEmail', [AdminController::class, 'deleteByEmail'])->middleware('checkrole:Admin');
    Route::post('/FApidetection',[FApiController::class,'Process'])->middleware('checkrole:Admin');
    Route::post('/updateWord', [RoadMapController::class,'UpdateWord'])->middleware('checkrole:Admin');
    Route::post('/CreateProgress', [RoadMapController::class,'CreateProgress'])->middleware('checkrole:Admin');
    Route::post('/AddWordsToLevel', [RoadMapController::class,'AddWordsToLevel'])->middleware('checkrole:Admin');
});

    
