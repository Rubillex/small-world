<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     *  Получает имя пользователя, стартует новую сессию, отдает обратно ссылку на игру.
     *
     * @param Request $request
     */
    public function startSession(Request $request) {
        if (!$request->name) {
            return;
        }
        // todo php artisan migrate + изменил в файлике env адрес, нужно доразобраться

    }
}
