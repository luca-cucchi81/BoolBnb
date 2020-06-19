<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Message;

class MessageController extends Controller
{
    public function getAll($user_id){
        $arrayMsg = [];
        $apartments = DB::table('apartments')->where('user_id', $user_id)->get();
        foreach ($apartments as $apartment) {
            $messages = Message::where('apartment_id', $apartment->id)->get();
            foreach ($messages as $message) {
                $arrayMsg[$apartment->id][] = $message;
            }
        }
        foreach ($arrayMsg as $key => $msg) {
            $arrayMsg[$key] = count($arrayMsg[$key]);
        }
        return response()->json($arrayMsg);
    }
}
