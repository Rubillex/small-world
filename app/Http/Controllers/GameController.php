<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller {
    /**
     *  Получает имя пользователя, стартует новую сессию, отдает обратно ссылку на игру.
     *
     * @param Request $request
     */
    public function startSession(Request $request) {
        //  todo Получить юзера, запихнуть его в юзер1, остальных заполнять на инвайтах
        // и вообще утащить это нафиг в модель
        try {
            //todo написать доку для $game
            $game = Game::create();

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            echo '<pre>';print_r($e);echo '</pre>';die();
        }

        return json_encode(['id' => $game->id]);
    }

    /**
     * Создает лобби, а также минимально отрисовывает его, тут же выдает idшник для подлючения
     * @param Request $request
     * @param string $id
     */
    public function connectToGame(Request $request, $id) {
        echo '<pre>';print_r($id);echo '</pre>';die();
        //todo протащить это во вью :) а на сегодня всё
        return view('index')->with('data', ['page' => 'index']);
    }

}
