<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',                      [HomeController::class, 'index']);
Route::get('/home',                  [HomeController::class, 'index'])->name('home');
Route::get('/login',                 [HomeController::class, 'login']);
Route::get('/register',              [HomeController::class, 'register']);
Route::get('/game',                  [HomeController::class, 'homePage']);
Route::get('/profile',            [HomeController::class, 'profile']);

Route::post('/api/start-session',          [GameController::class, 'startSession']);
Route::post('/api/add-user-to-lobby/{id}', [GameController::class, 'addUserToLobby']);
Route::post('/api/logout',                 [GameController::class, 'logOut']);

Route::get('/levels',                      [TestsController::class, 'getLevels']);
Route::get('/level/{number}',              [TestsController::class, 'goToLevel']);
Route::get('/level/{number}/answer',       [TestsController::class, 'goToLevelAnswers']);

Route::get('/game/{id}', [GameController::class, 'connectToGame']);

Route::post('/api/change-difficult/{complexity}', [UserController::class, 'changeComplexity']);
Route::post('/api/change-lifes/{lifes}', [UserController::class, 'changeLifes']);
Route::get('/api/getLeaderboard', [UserController::class, 'getLeaderboard']);

Route::post('/api/getlevels',                [TestsController::class, 'getlevels']);
Route::post('/api/getlevelData/{levelId}',   [TestsController::class, 'getLevelData']);
Route::post('/api/test-complited/{levelId}/{points}', [TestsController::class, 'addUserToTestComplited']);

Route::post('api/upload-file/{file}', [TestsController::class, 'uploadFile']);

Route::get('/phpInfo', function() {
    return response()->json([
        'stuff' => phpinfo()
    ]);
});

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
