<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * Отвечает за переходы по страницам.
 */
class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Возвращает индекс для неавторизованных иначе страницу с началом игры
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        if (Auth::check()) {
           return $this->profile();
        } else {
            return view('index')->with('data', ['page' => 'index']);
        }
    }

    /**
     * Возвращает страницу с началом игры
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function homePage(): \Illuminate\Contracts\View\View {
        $user = User::find(Auth::id());
        if (!$user) return view('index')->with('data', ['page' => 'index']);
        if ($user->complexity === '-1')   return $this->profile();

        return view('complexity');
    }

    /**
     * Возвращает страницу логина
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login() {
        return view('login')->with('data', ['page' => 'login']);
    }

    /**
     * Возвращает страницу регистрации
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function register() {
        return view('register')->with('data', ['page' => 'register']);
    }

    /**
     * Возвращает страничку профиля игрока
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function profile(){
        $userList = User::all();
        $currentUser = $userList->firstWhere('id', Auth::id());
        if ($currentUser->complexity === '-1' || $currentUser->lifes == 0) return view('complexity');

        $currentName = $currentUser->name;
        $currentPoints = $currentUser->points;
        $currentLifes = $currentUser->lifes;
        $userIndex = $userList->sortByDesc('score')->pluck('id')->search(Auth::id());

        $userInTop = ($userIndex + 1) <= 3;

        $userSorted = $userList->sortByDesc('score')->take(3)
            ->map(function ($item, $key) {
                return [
                        'name'   => $item['name'],
                        'points' => $item['score']
                ];
            })
            ->toArray();
        $userSorted = array_values($userSorted);

        return view('profile', [
            'data' => [
                'usersList'         => $userSorted,
                'currentUserName'   => $currentName,
                'currentUserPoints' => $currentPoints,
                'currentUserIndex'  => $userIndex + 1,
                'userInTop'         => $userInTop,
                'currentUserLifes'  => $currentLifes,
            ],
        ]);
    }
}
