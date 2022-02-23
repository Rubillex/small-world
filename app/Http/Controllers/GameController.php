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

        if (Auth::check() === false) {
            return json_encode(['error' => 'Вы не авторизированы.']);
        }
        $userId = Auth::id();

        try {
            //todo написать доку для $game
            $game = Game::create();
            $game->users = json_encode([$userId]);
            $game->save();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return json_encode(['error' => $e]);
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
        //todo протащить это во вью :) а на сегодня всё
        return view('lobby')->with('data', ['page' => $id]);
    }

    /**
     * Подключает юзера к лобби по GameID
     */
    public function addUserToLobby($id) {
        try{
            $lobby = Game::where('id', $id)->firstOrFail();
            $userId = Auth::id();
            $users = json_decode($lobby->users);
            if (count($users) > 4) return json_encode(['error' => 'lobby has fulled']);
            foreach ($users as $user) {
                if ($user === $userId) return json_encode(['id' => $lobby->id]);
            }

            $users[] = $userId;
            $lobby->users = json_encode($users);
            $lobby->save();

            return json_encode(['id' => $lobby->id]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return json_encode(['error' => 'lobby not found']);
        }
    }

}
