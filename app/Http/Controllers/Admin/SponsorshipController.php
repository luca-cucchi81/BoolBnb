<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Sponsorship;
use App\Apartment;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $apartment = $data['apartment'];

        if (!isset($data['sponsorship'])) { // Check se hai selezionato nel form il tipo di sponsorizzazione
            return redirect()->route('admin.apartments.sponsor', $apartment)
                ->with('failure', 'Select Sponsorship Plan');
        }

        $sponsorship = Sponsorship::findOrFail($data['sponsorship']);
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addDays($sponsorship->duration)->format('Y-m-d'); // Aggiungo giorni alla data odierna in base al tipo di sponsorizzazione
        $attached = $sponsorship->apartments()->attach($apartment, ['start_date' => $startDate, 'end_date' => $endDate]); // Creazione del campo nella tabella pivot con data di inizio e fine della sponsorizzazione

        return redirect()->route('admin.apartments.show', $apartment)
            ->with('success', 'Apartment ' . $apartment . ' sponsored.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        $sponsorships = Sponsorship::all();

        return view('admin.apartments.sponsor', compact('apartment', 'sponsorships'));
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
