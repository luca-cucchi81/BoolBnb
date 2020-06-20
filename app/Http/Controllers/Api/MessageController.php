<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Message;

class MessageController extends Controller
{
    public function getAll($user_id){
        $arrayMsg = []; // Inizializzo un array che trasformerò in json
        $apartments = DB::table('apartments')->where('user_id', $user_id)->get(); // Trovo tutti gli appartamenti relativi allo user_id in ingresso
        foreach ($apartments as $apartment) {
            $messages = Message::where('apartment_id', $apartment->id)->get(); // Cerco i messaggi per ogni appartamento ciclato
            foreach ($messages as $message) {
                $arrayMsg[$apartment->id][] = $message; // Ogni singolo messaggio lo pusho all'interno dell'array iniziale nella chiave corrispondente all'appartamento
            }
        }
        foreach ($arrayMsg as $key => $msg) {
            $arrayMsg[$key] = count($arrayMsg[$key]); // Per ogni chiave dell'array sostituisco i valori pushati prima con il count di questi
        }
        return response()->json($arrayMsg); // Ritorno il json dell'array creato
    }
}
