<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
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
Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [HomeController::class, 'login']);
Route::get('/register', [HomeController::class, 'register']);
Route::get('/game', [HomeController::class, 'homePage']);
Route::get('/game/{id}', [GameController::class, 'connectToGame']);



Route::post('/api/start-session', [GameController::class, 'startSession']);
Route::post('/api/add-user-to-lobby/{id}', [GameController::class, 'addUserToLobby']);
Route::post('/api/logout', [GameController::class, 'logOut']);
Route::post('/api/change-difficult/{complexity}', [UserController::class, 'changeComplexity']);

Route::get('/phpInfo', function() {
    return response()->json([
        'stuff' => phpinfo()
    ]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
