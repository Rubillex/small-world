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
     * Show the application dashboard.
     *
     *
     */
    public function index(Request $request) {
//        Auth::logout();
        if (Auth::check()) {
            return view('game')->with('data', ['page' => 'game']);
        } else {
            return view('index')->with('data', ['page' => 'index']);
        }
    }

    public function homePage(Request $request){
        return view('game')->with('data', ['page' => 'game']);
    }

    public function login(Request  $request) {
        return view('login')->with('data', ['page' => 'login']);
    }

    public function register(Request $request) {
        return view('register')->with('data', ['page' => 'register']);
    }
}
