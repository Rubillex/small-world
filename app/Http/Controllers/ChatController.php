<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function createChat() {
        $chatMessage = [
            'name' => 'dmitry',
            'message' => 'privet',
        ];
        event(new \App\Events\LoadChat($chatMessage));
    }
}
