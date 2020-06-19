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
        $arraySpn = [];
        $apartments = DB::table('apartments')->where('user_id', $user_id)->get();
        foreach ($apartments as $apartment) {
            $arraySpn[$apartment->id] = 0;
            $sponsorships = DB::table('apartment_sponsorship')->where('apartment_id', $apartment->id)->get();
            foreach ($sponsorships as $sponsorship) {
                $sponsorshipsinfos = DB::table('sponsorships')->where('id', $sponsorship->sponsorship_id)->get();
                foreach ($sponsorshipsinfos as $sponsorshipsinfo) {
                    $price = $sponsorshipsinfo->price;
                    $arraySpn[$apartment->id] = $arraySpn[$apartment->id] + $price;
                }
            }
        }
        return response()->json($arraySpn);
    }
}
