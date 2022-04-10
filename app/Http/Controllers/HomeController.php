<?php

namespace App\Http\Controllers;

use App\Models\Pictures;
use Doctrine\DBAL\Query;
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
     * Возвращает страницу загрузки изображений
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function uploadImage(){
        if (Auth::id() === 1){
            return view('upload')->with('data', ['page' => 'upload']);
        } else {
            return view('index')->with('data', ['page' => 'index']);
        }
    }

    /**
     * Возвращает страничку профиля игрока
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function profile(){
        if (!Auth::check()) return view('index')->with('data', ['page' => 'index']);
        $userList = User::all();
        $currentUser = $userList->firstWhere('id', Auth::id());
        if ($currentUser->complexity === '-1' || $currentUser->lifes == 0) return view('complexity');

        $currentName = $currentUser->name;
        $currentPoints = $currentUser->points;
        $currentLifes = $currentUser->lifes;
        $currentComplexity = $currentUser->complexity;
        $userIndex = $userList->sortByDesc('score')->pluck('id')->search(Auth::id());

        $userInTop = ($userIndex + 1) <= 3;

        $userSorted = $userList->sortByDesc('score')->take(3)
            ->map(function ($item, $key) {
                return [
                        'name'   => $item['name'],
                        'points' => $item['score'],
                        'id'     => $item['id']
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
                'complexity'        => $currentComplexity,
            ],
        ]);
    }

    /**
     * загрузка изображений на сервер
     */
    public function uploadImageAPI(Request $request) {

        $path = $request->file('image')->store('images', 'public');
        return [
            'path' => $path,
        ];
    }


    /**
     * Возвращает таблицу лидеров
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function leaderboard() {
        $userList = User::all();

        $userSorted = $userList->sortByDesc('score')
            ->map(function ($item, $key) {
                return [
                    'name'   => $item['name'],
                    'points' => $item['score'],
                    'id'     => $item['id']
                ];
            })
            ->toArray();
        $userSorted = array_values($userSorted);

        return view('leaderboard', [
            'data' => [
                'leaderboard' => $userSorted,
            ],
        ]);
    }
}
