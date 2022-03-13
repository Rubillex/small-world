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
            $user =  User::find(Auth::id());
            $user->complexity = $complexity;
            $user->save();

            return ['success' => true];
    }
}
