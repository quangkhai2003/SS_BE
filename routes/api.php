<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RoadMapController;

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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('checkrole:User');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('checkrole:User');
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('checkrole:User');
    Route::post('/getWordInLevel', [RoadMapController::class,'GetWordInLevel'])->middleware('checkrole:User');
    Route::post('/loginGuest', [GuestController::class, 'loginGuest']);
    Route::post('/logoutGuest', [GuestController::class, 'logoutGuest'])->middleware('checkrole:Guest');
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'admin',

], function ($router) {
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout']);
    //Route::get('/profile', [AdminController::class, 'logout'])->middleware('checkrole:Admin');
});

    
