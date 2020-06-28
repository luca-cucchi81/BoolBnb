<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Apartment;
use App\Service;
use App\Image;
use App\Message;
use App\Sponsorship;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::orderBy('updated_at', 'desc')->get(); // Tutti gli appartamenti in ordine decrescente
        $userId = Auth::id();

        return view('admin.apartments.index', compact('apartments', 'userId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();

        return view('admin.apartments.create', compact('services'));
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
        $data['user_id'] = Auth::id(); // Creo il campo user_id
        $now = Carbon::now()->format('Y-m-d-H-i-s');
        $data['slug'] = Str::slug($data['title'] , '-') . '-' . $now; // Creo il campo slug

        if (isset($data['main_img'])) { // Se dal form arriva l'immagine la carico con Storage e creo il campo con il path
            $path = Storage::disk('public')->put('images', $data['main_img']);
            $data['main_img'] = $path;
        }

        if (!isset($data['visibility'])){ // Se dal form non arriva la visibilità la rendo zero altrimenti uno
            $data['visibility'] = 0;
        } else {
            $data['visibility'] = 1;
        }

        if (!isset($data['services'])){ // se dal form non arrivano i servizi creo un array vuoto di servizi per non avere problemi di validazione
            $data['services'] = [];
        }

        $validator = Validator::make($data, [
            'title' => 'required|max:100',
            'description' => 'required',
            'rooms' => 'required|integer',
            'beds' => 'required|integer',
            'bathrooms' => 'required|integer',
            'square_meters' => 'required|integer',
            'address' => 'required|max:255',
            'services' => 'array',
            'services.*' => 'exists:services,id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.apartments.create')
                ->withErrors($validator)
                ->withInput();
        }

        $apartment = new Apartment;

        $apartment->fill($data);
        $saved = $apartment->save();

        $apartment->services()->attach($data['services']);

        if (!$saved) {
            return redirect()->route('admin.apartments.create')
                ->with('failure', 'Apartment not created.');
        }

        return redirect()->route('admin.apartments.show', $apartment->id)
            ->with('success', 'Apartment ' . $apartment->id . ' created.');
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
        $now = Carbon::now();
        $hide = false; // Variabile sentinella
        $sponsorships = $apartment->sponsorships;

        foreach ($sponsorships as $sponsorship) { // Check su ogni sponsorizzazione dell'appartmento, se una sola è vera la variabile sentinella diventa true
            if ($sponsorship->pivot->end_date > $now) {
                $hide = true;
            }
        }

        $total = 0;
        foreach ($sponsorships as $sponsorship) {
            $price = $sponsorship->price; // Assegno a una variabile il valore price della sponsorizzazione ciclata
            $total = $total + $price; // Aggiungo questo valore al valore esistente nella chiave dell'appartamento corrispondente
        }

        $messages = Message::where('apartment_id', $apartment->id)->orderBy('id', 'desc')->get();
        foreach ($messages as $message){ // Ad ogni messaggio cambio il campo read in 1 per capire che è stato letto dall'utente
            $message->read = 1;
            $message->save();
        }

        return view('admin.apartments.show', compact('apartment', 'messages', 'hide', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $services = Service::all();
        $apartment = Apartment::findOrFail($id);
        $images = Image::where('apartment_id', $apartment->id)->get();

        return view('admin.apartments.edit', compact('apartment', 'images', 'services'));
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
        $apartment = Apartment::findOrFail($id);
        $data = $request->all();

        $now = Carbon::now()->format('Y-m-d-H-i-s');
        $data['slug'] = Str::slug($data['title'] , '-') . '-' . $now;
        $userId = Auth::id();
        $author = $apartment->user_id;

        if($userId != $author) {
            return redirect()->route('admin.apartments.index')
                ->with('failure', 'Edit denied');
        }

        if (!isset($data['visibility'])){ // Solito check sulla visibilità
            $data['visibility'] = 0;
        } else {
            $data['visibility'] = 1;
        }

        if (isset($data['main_img'])) { // Se dal form arriva l'immagine cancello la vecchia dallo storage e salvo la nuova
            $deleted = Storage::disk('public')->delete($apartment->main_img);
            $path = Storage::disk('public')->put('images', $data['main_img']);
            $data['main_img'] = $path;
        }

        if (isset($data['images'])){ // Se dal form arriva l'array delle immagini secondarie per ognuna creo un'istanza nella tabella images
            foreach ($data['images'] as $image){
                $path = Storage::disk('public')->put('images', $image);
                $newImage = new Image;
                $newImage->path = $path;
                $newImage->apartment_id = $apartment->id;
                $newImage->save();
            }
        }

        if (!isset($data['services'])) {
            $data['services'] = [];
        }

        $validator = Validator::make($data, [
            'title' => 'max:100',
            'rooms' => 'integer',
            'beds' => 'integer',
            'bathrooms' => 'integer',
            'square_meters' => 'integer',
            'address' => 'max:255',
            'services' => 'array',
            'services.*' => 'exists:services,id',
            'images' => 'array'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.apartments.edit', $apartment->id)
                ->withErrors($validator)
                ->withInput();
        }

        $apartment->fill($data);
        $updated = $apartment->update();

        $apartment->services()->sync($data['services']);

        if (!$updated) {
            return redirect()->route('admin.apartments.edit', $apartment->id)
                ->with('failure', 'Apartment not updated.');
        }

        return redirect()->route('admin.apartments.show', $apartment->id)
            ->with('success', 'Apartment ' . $apartment->id . ' updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apartment = Apartment::findOrFail($id);

        $apartment->sponsorships()->detach(); // Quando cancello un appartamento detacho tutte le relative relazioni e le immagini collegate
        $apartment->services()->detach();
        $apartment->images()->delete();
        $apartment->messages()->delete();
        $apartment->visits()->delete();
        $deleted = Storage::disk('public')->delete($apartment->main_img);

        $deleted = $apartment->delete();

        if(!$deleted){
            return redirect()->route('admin.apartments.index')
                ->with('failure', 'Apartment ' . $apartment->id . ' not removed.');
        }

        return redirect()->route('admin.apartments.index')
            ->with('success', 'Apartment ' . $apartment->id . ' removed.');
    }
}
