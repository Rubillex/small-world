<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        // добавил получение юзера и убил таблицу games. В таблице не было таких же записей, как и в модельке

        if (!Auth::check()) {
            return view('index')->with('data', ['page' => 'index']);
        }
        $userId = Auth::id();
        $user = User::where('id', $userId)->firstOrFail();

        try {
            //todo написать доку для $game
            $game = Game::create();
            $game->user1 = $userId;
            $game->save();
//            echo '<pre>';print_r($game->id);echo '</pre>';die();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            echo '<pre>';print_r($e);echo '</pre>';die();
        }

        return json_encode(['id' => $game->id]);
    }

    public function logOut(){
        Auth::logout();
    }

    /**
     * Создает лобби, а также минимально отрисовывает его, тут же выдает idшник для подлючения
     * @param Request $request
     * @param string $id
     */
    public function connectToGame(Request $request, $id) {
//        echo '<pre>';print_r($id);echo '</pre>';die();
        //todo протащить это во вью :) а на сегодня всё
        return view('lobby')->with('data', ['page' => 'lobby']);
    }

    /*
     * Подключает юзера к лобби по GameID
     */
    public function addUserToLobby(Request $request, $id) {
        try{
            $lobby = Game::where('id', $id)->firstOrFail();
            $userId = Auth::id();
            if ($lobby->user1 === $userId){
                return json_encode(['id' => $lobby->id]);
            } else
            if ($lobby->user2 === "" && $lobby->user2 !== $userId) {
                $lobby->user2 = $userId;
                $lobby->save();
                return json_encode(['id' => $lobby->id]);
            } else if($lobby->user3 === "" && $lobby->user3 !== $userId) {
                $lobby->user3 = $userId;
                $lobby->save();
                return json_encode(['id' => $lobby->id]);
            } else if($lobby->user4 === "" && $lobby->user4 !== $userId) {
                $lobby->user4 = $userId;
                $lobby->save();
                return json_encode(['id' => $lobby->id]);
            } else return json_encode(['error' => 'lobby is full']);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return json_encode(['error' => 'lobby not found']);
        }
    }

}
