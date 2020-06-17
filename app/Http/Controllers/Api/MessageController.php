<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function getAll(){
        $messages = Message::all();

        return response()->json($messages);
    }
}
