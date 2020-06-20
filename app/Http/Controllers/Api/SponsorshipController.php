<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Apartment;
use App\Sponsorship;

class SponsorshipController extends Controller
{
    public function getAll($user_id)
    {
        $arraySpn = []; // Array da trasformare in json
        $apartments = DB::table('apartments')->where('user_id', $user_id)->get(); // Lista appartamenti con user_id in ingresso
        foreach ($apartments as $apartment) {
            $arraySpn[$apartment->id] = 0; // Per ogni appartamento creo una chiave nell'array settata a zero per poi fare calcoli numerici (riga24)
            $sponsorships = DB::table('apartment_sponsorship')->where('apartment_id', $apartment->id)->get(); // Sponsorizzazioni per ogni appartamento
            foreach ($sponsorships as $sponsorship) {
                $sponsorshipsinfos = DB::table('sponsorships')->where('id', $sponsorship->sponsorship_id)->get(); // Informazioni per ogni singola sponsorizzazione
                foreach ($sponsorshipsinfos as $sponsorshipsinfo) {
                    $price = $sponsorshipsinfo->price; // Assegno a una variabile il valore price della sponsorizzazione ciclata
                    $arraySpn[$apartment->id] = $arraySpn[$apartment->id] + $price; // Aggiungo questo valore al valore esistente nella chiave dell'appartamento corrispondente
                }
            }
        }
        return response()->json($arraySpn);
    }
}
