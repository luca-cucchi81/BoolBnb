<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Apartment;
use App\Message;
use App\Sponsorship;
use App\Visit;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::id();
        $visitsCount = 0;
        $apartments = Apartment::where('user_id', $userId)->get(); // Appartmenti dello user_id in ingresso

        foreach ($apartments as $apartment) {
            $visits = Visit::where('secondary_key', $apartment->id)->get(); // Visite relative all'appartamento ciclato
            foreach ($visits as $visit) {
                if ($visit->primary_key == 'visits:apartments_visits') { // Per ogni visita prendo solo il campo delle visite totali
                    $score = $visit->score; // E il valore score della tabella lo pusho nell'array principale all'appartamento corrispondente
                    $visitsCount = $visitsCount + $score;
                }
            }
        }

        $messagesCount = 0;
        foreach ($apartments as $apartment) {
            foreach($apartment->messages as $messagesAll){ // Ciclo su ogni messaggio dell'appartmento
                foreach ($messagesAll as $singleMessage){ // Ad ogni messaggio cambio il campo read in 1 per capire che è stato letto dall'utente
                    $messagesCount = $messagesCount + 1;
                }
            }
        }

        $spnCount = 0;
        $totalAmountSp = 0;
        foreach ($apartments as $apartment) {
            $sponsorships = $apartment->sponsorships;
            foreach ($sponsorships as $sponsorship) {
                $spnCount = $spnCount + 1;
                $price = $sponsorship->price; // Assegno a una variabile il valore price della sponsorizzazione ciclata
                $totalAmountSp = $totalAmountSp + $price; // Aggiungo questo valore al valore esistente nella chiave dell'appartamento corrispondente
            }
        }

        return view('home', compact('userId', 'visitsCount', 'messagesCount', 'spnCount', 'totalAmountSp'));
    }
}
