<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
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
Route::get('/start-game', [GameController::class, 'startGame']);

Route::post('/api/start-session', [GameController::class, 'startSession']);

Route::get('/phpInfo', function() {
    return response()->json([
        'stuff' => phpinfo()
    ]);
});
