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
        $arrayVisits = [];
            $apartments = DB::table('apartments')->where('user_id', $user_id)->get();
            foreach ($apartments as $apartment) {
                $visits = Visit::where('secondary_key', $apartment->id)->get();
                foreach ($visits as $visit) {
                    if ($visit->primary_key == 'visits:apartments_visits') {
                        $arrayVisits[$apartment->id] = $visit->score;
                    }
                }
            }
        return response()->json($arrayVisits);
    }

    public function getPeriods($apartment_id)
    {
        $arrayVisits = [];
        $apartment = DB::table('apartments')->where('id', $apartment_id)->first();
        $visits = Visit::where('secondary_key', $apartment->id)->get();
        foreach ($visits as $visit) {
            if ($visit->primary_key == 'visits:apartments_visits') {
                $arrayVisits['Totale Visite'] = $visit->score;
            } elseif ($visit->primary_key == 'visits:apartments_visits_year') {
                $arrayVisits['Visite ultimo anno'] = $visit->score;
            } elseif ($visit->primary_key == 'visits:apartments_visits_month') {
                $arrayVisits['Visite questo mese'] = $visit->score;
            } elseif ($visit->primary_key == 'visits:apartments_visits_week') {
                $arrayVisits['Visite questa settimana'] = $visit->score;
            } elseif ($visit->primary_key == 'visits:apartments_visits_day') {
                $arrayVisits['Visite oggi'] = $visit->score;
            }
        }
        return response()->json($arrayVisits);
    }
}
