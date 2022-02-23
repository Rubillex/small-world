<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function createChat() {
        $chatMessage = [
            'name' => 'piska',
            'message' => 'huy',
        ];
        event(new \App\Events\LoadChat($chatMessage));
    }
}
