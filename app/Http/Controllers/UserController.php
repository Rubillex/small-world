<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


/**
 * Отвечает за работу с пользователем.
 */
class UserController extends Controller
{
    /**
     * Присваивает сложность пользователю
     */
    public function changeComplexity($complexity) {
        $user             = User::find(Auth::id());
        $user->complexity = $complexity;

        $user->points = 0;
        if($user->score !== 0) $user->score = ceil($user->score / 2);

        $lifes = 0;
        switch ($complexity) {
            case 1:
                $lifes = 3;
                break;
            case 2:
                $lifes = 2;
                break;
            case 3:
                $lifes = 1;
                break;
            default:
                $lifes = 0;
                break;
        }
        $user->lifes = $lifes;
        $user->save();

        return ['success' => true];
    }

    /**
     * Устанавливаем жизни пользователю
     */
    public function changeLifes($lifes) {
        $user             = User::find(Auth::id());
        $user->lifes      = $lifes;
        if ($user->lifes === 0){
            $user->complexity = -1;
        }
        $user->save();
        return ['success' => true];
    }

    /**
     * Возвращает глобальную таблицу лидеров
     * @return array
     */
    public function getLeaderboard() {
        $userList = User::all();
        $userSorted = $userList->sortByDesc('score')
            ->map(function ($item) {
                return [
                    'name'   => $item['name'],
                    'points' => $item['score'],
                    'id'     => $item['id']
                ];
            })
            ->toArray();
        $userSorted = array_values($userSorted);

        return [
            'leaderboard' => $userSorted,
        ];
    }
}
