<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
            return view('game')->with('data', ['page' => 'game']);
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
        return view('game')->with('data', ['page' => 'game']);
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
     * Возвращает страницу логина
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function register() {
        return view('register')->with('data', ['page' => 'register']);
    }
}
