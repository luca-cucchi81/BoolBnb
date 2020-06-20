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
}
