<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;

class ApartmentController extends Controller
{
    public function getAll(){
        $apartments = Apartment::all();

        return response()->json($apartments);
    }

    public function visitDay(){

        $apartments = visits('App\Apartment')->top(10);
        $visitsDay = [];
        foreach ($apartments as $apartment) {
            $visitApartment = [];
            $visitApartment['apartment_id'] = $apartment->id;
            $visitApartment['visitDay'] = visits($apartment)->period('day')->count();
            $visitsDay[] = $visitApartment;
        }
        return response()->json($visitsDay);
    }
}
