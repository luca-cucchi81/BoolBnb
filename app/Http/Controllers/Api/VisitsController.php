<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Visit;

class VisitsController extends Controller
{
    public function getAll($user_id){
        $arrayVisits = []; // Array che diventerà json
        $apartments = DB::table('apartments')->where('user_id', $user_id)->get(); // Appartmenti dello user_id in ingresso
        foreach ($apartments as $apartment) {
            $visits = Visit::where('secondary_key', $apartment->id)->get(); // Visite relative all'appartamento ciclato
            foreach ($visits as $visit) {
                if ($visit->primary_key == 'visits:apartments_visits') { // Per ogni visita prendo solo il campo delle visite totali
                    $arrayVisits[$apartment->id] = $visit->score; // E il valore score della tabella lo pusho nell'array principale all'appartamento corrispondente
                }
            }
        }
        return response()->json($arrayVisits);
    }

    public function getPeriods($apartment_id)
    {
        $arrayVisits = [ // Inizializzo un Array dando come valori di default alle chiavi zero per poi aggiornarle con le visite reali corrispondenti
            'Totali' => 0,
            'Anno' => 0,
            'Mese' => 0,
            'Settimana' => 0,
            'Oggi' => 0
        ];
        $apartment = DB::table('apartments')->where('id', $apartment_id)->first(); // Appartamento con id in ingresso
        $visits = Visit::where('secondary_key', $apartment->id)->get(); // Visite relative a questo appartamento
        foreach ($visits as $visit) { // Per ogni visita pusho nell'array il valore corrispondente a ogni singola chiave
            if ($visit->primary_key == 'visits:apartments_visits') { // Visite totali
                $arrayVisits['Totali'] = $visit->score;
            } elseif ($visit->primary_key == 'visits:apartments_visits_year') { // Visite ultimo anno
                $arrayVisits['Anno'] = $visit->score;
            } elseif ($visit->primary_key == 'visits:apartments_visits_month') { // Visite ultimo mese
                $arrayVisits['Mese'] = $visit->score;
            } elseif ($visit->primary_key == 'visits:apartments_visits_week') { // Visite ultima settimana
                $arrayVisits['Settimana'] = $visit->score;
            } elseif ($visit->primary_key == 'visits:apartments_visits_day') { // Visite oggi
                $arrayVisits['Oggi'] = $visit->score;
            }
        }
        return response()->json($arrayVisits);
    }
}
