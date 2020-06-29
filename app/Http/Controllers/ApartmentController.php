<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

use Carbon\Carbon;

use App\Apartment;
use App\Sponsorship;
use App\Service;
use App\Message;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::whereHas('sponsorships', function (Builder $query) {
            $query->where('price', '=', '9.99')
            ->where('end_date', '>=', Carbon::now());
        })->inRandomOrder()->get();

        $arrayApartments = [];
        foreach ($apartments as $apartment) {
            $arrayApartments[] = $apartment;
        }

        foreach ($arrayApartments as $arrayApartment) {
            $city = explode(', ', $arrayApartment->address);
            $arrayApartment->address = $city[1];
        }

        return view('guest.apartments.index', compact('arrayApartments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        function distanceResults($lat1, $lon1, $latitude, $longitude, $unit) // Funzione che confronta due coppie di latitudine e longitudine per trovare la distanza tra esse
        {
            $theta = $lon1 - $longitude;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($latitude)) + cos(deg2rad($lat1)) * cos(deg2rad($latitude)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        };

        $apartments = Apartment::where('visibility', 1)->get();
        $filteredApartments = [];
        $sponsoredApartments = [];

        $services = Service::all();
        $data = $request->all();

        if (isset($data['address'])) { // Se dal form arriva l'indirizzo
            $oldAddress = $data['address']; // Assegno a una variabile l'indirizzo
            $oldLat = floatval($data['lat']); // Assegno a due variabili lat e lgn che arrivano dai due input nascosti
            $oldLng = floatval($data['lng']);
        } else { // Se dal form non arriva l'indirizzo popolo indirizzo, lat e lng con i valori vecchi
            if (!isset($data['oldAddress'])) {
                return redirect()->route('guest.apartments.index')
                    ->with('failure', 'Address Required');
            }
            $data['address'] = $data['oldAddress'];
            $data['lat'] = $data['oldLat'];
            $data['lng'] = $data['oldLng'];
            $oldAddress = $data['address']; // Aggiorno queste variabili
            $oldLat = floatval($data['lat']);
            $oldLng = floatval($data['lng']);
        }

        $dataLat = floatval($data['lat']);
        $dataLng = floatval($data['lng']);

        if (isset($data['radius'])) { // Se dal form arriva il radius la variabile prenderà quel valore altrimenti gli diamo 20 di default
            $radius = (int)$data['radius'];
        } else {
            $radius = 20;
        }

        foreach ($apartments as $apartment) {
            $apartmentLat = $apartment->lat;
            $apartmentLng = $apartment->lng;

            $result = distanceResults($apartmentLat, $apartmentLng, $dataLat, $dataLng, 'k'); // Assegno a una variabile il risultato della funzione di distanza che darà un numero intero
            $apartment['distance'] = $result;
            if ($result <= $radius) { // Se questo numero è minore del radius vado avanti
                foreach ($apartment->sponsorships as $sponsorship) {
                    $now = Carbon::now();
                    $endDate = $sponsorship->pivot->end_date; // Faccio un check per ogni appartamento se è sposnsorizzato attualmente o no
                    if ($now < $endDate && !in_array($apartment, $sponsoredApartments)) { // Se lo è lo metto nell'array sponsorizzati
                        $sponsoredApartments[] = $apartment;
                    }
                }
                if (!in_array($apartment, $sponsoredApartments)) { // Altrimenti lo metto nell'array normale
                    $filteredApartments[] = $apartment;
                }
            }
        }

        $distance = array_column($sponsoredApartments, 'distance');
        array_multisort($distance, SORT_ASC, $sponsoredApartments);

        $distance = array_column($filteredApartments, 'distance');
        array_multisort($distance, SORT_ASC, $filteredApartments);

        if (count($filteredApartments) == 0 && count($sponsoredApartments) == 0) { // Se tutti e due questi array risultano vuoti la ricerca fallisce
            return redirect()->route('guest.apartments.index')
                ->with('failure', 'No Apartments Available');
        }

        return view('guest.apartments.search', compact('sponsoredApartments', 'filteredApartments', 'dataLat', 'dataLng', 'services', 'oldAddress', 'oldLat', 'oldLng', 'radius'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'sender' => 'required|email',
            'body' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('guest.apartments.show', $data['slug'])
                ->withErrors($validator)
                ->withInput();
        }

        $message = new Message;

        $message->fill($data);
        $saved = $message->save();

        if (!$saved) {
            return redirect()->route('guest.apartments.show', $data['slug'])
                ->with('failure', 'Message not sent');
        }

        return redirect()->route('guest.apartments.show', $data['slug'])
            ->with('success', 'Message sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->first();
        if (isset(Auth::user()->email)) { // Se l'utente è loggato assegno a una variabile la sue email altrimenti è vuota
            $userEmail = Auth::user()->email;
        } else {
            $userEmail = '';
        }

        $userId = Auth::id();
        if ($apartment->user_id != $userId) { // Se non sei il proprietario dell'appartamento aumento di uno le visualizzazioni
            visits($apartment)->increment();
        }

        return view('guest.apartments.show', compact('apartment', 'userEmail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
