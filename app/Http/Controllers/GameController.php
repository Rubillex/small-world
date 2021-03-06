<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
//use Redis;


class GameController extends Controller {
    /**
     * Функция для выхода из профиля
     */
    public function logOut() {
        Auth::logout();
    }

    /**
     * Создает лобби, а также минимально отрисовывает его, тут же выдает idшник для подлючения
     * @param string $id
     */
    public function connectToGame($id) {
        if (!Auth::check()) {
            return view('index')->with('data', ['page' => 'index']);
        }

        return view('lobby')->with('data', ['chatData' => ['lobbyId' => $id, 'userData' => Auth::user()]]);
    }
}
