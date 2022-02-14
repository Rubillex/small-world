<?php

namespace App\Http\Controllers;

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

        try {
            $user = User::where('name', $request->name)->firstOrFail();
            echo "Такой юзер уже существует!\n" . $user->name . " " . $user->email . " " . $user->password;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $newUser = User::create([
                'name'     => $request->name,
                'email'    => $request->name . '@qwe.q',
                'password' => '12345678',
            ]);
            echo "Регистрация прошла успешно!";


        }
        return;
        // todo php artisan migrate + изменил в файлике env адрес, нужно доразобраться

    }

    //
    public function startGame(Request  $request) {
        return view('index')->with('data', ['page' => 'index']);
    }

}
