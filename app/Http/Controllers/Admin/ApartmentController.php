<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Service;
use App\Apartment;
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
        $apartments = Apartment::orderBy('updated_at', 'desc')->get();
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
        $data['user_id'] = Auth::id();
        $now = Carbon::now()->format('Y-m-d-H-i-s');
        $data['slug'] = Str::slug($data['title'] , '-') . '-' . $now;
        if (isset($data['main_img'])) {
            $path = Storage::disk('public')->put('images', $data['main_img']);
            $data['main_img'] = $path;
        }

        if (!isset($data['visibility'])){
            $data['visibility'] = 0;
        } else {
            $data['visibility'] = 1;
        }

        if (!isset($data['services'])){
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
                ->with('failure', 'Appartamento non inserito.');
        }

        return redirect()->route('admin.apartments.show', $apartment->id)
            ->with('success', 'Appartamento ' . $apartment->id . ' inserito correttamente.');
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
        $hide = false;
        $sponsorships = $apartment->sponsorships;
        foreach ($sponsorships as $sponsorship) {
            if ($sponsorship->pivot->end_date > $now) {
                $hide = true;
            }
        }
        foreach($apartment->messages as $message){
            $messages = Message::where('apartment_id', $apartment->id)->get();
            foreach ($messages as $singleMessage){
                $singleMessage->read = 1;
                $singleMessage->save();
            }
        }

        return view('admin.apartments.show', compact('apartment', 'hide'));
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

        $userId = Auth::id();
        $author = $apartment->user_id;

        if($userId != $author) {
            return redirect()->route('admin.apartments.index')
                ->with('failure', 'Non puoi modificare un appartamento che non hai inserito tu');
        }

        $now = Carbon::now()->format('Y-m-d-H-i-s');
        $data['slug'] = Str::slug($data['title'] , '-') . '-' . $now;
        if (!isset($data['visibility'])){
            $data['visibility'] = 0;
        } else {
            $data['visibility'] = 1;
        }

        if (isset($data['main_img'])) {
            $deleted = Storage::disk('public')->delete($apartment->main_img);
            $path = Storage::disk('public')->put('images', $data['main_img']);
            $data['main_img'] = $path;
        }

        if (isset($data['images'])){
            foreach ($data['images'] as $image){
                $path = Storage::disk('public')->put('images', $image);
                $newImage = new Image;
                $newImage->path = $path;
                $newImage->apartment_id = $apartment->id;
                $newImage->save();
            }
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
                ->with('failure', 'Appartamento non modificato.');
        }

        return redirect()->route('admin.apartments.show', $apartment->id)
            ->with('success', 'Appartamento ' . $apartment->id . ' modificato correttamente.');
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

        $apartment->sponsorships()->detach();
        $apartment->services()->detach();
        $apartment->images()->delete();
        $apartment->messages()->delete();
        $apartment->views()->delete();
        $deleted = Storage::disk('public')->delete($apartment->main_img);

        $deleted = $apartment->delete();

        if(!$deleted){
            return redirect()->route('admin.apartments.index')
                ->with('failure', 'Appartamento ' . $apartment->id . ' non eliminato.');
        }

        return redirect()->route('admin.apartments.index')
            ->with('success', 'Appartamento ' . $apartment->id . ' eliminato correttamente.');
    }

    public function sponsor($id) {
        $apartment = Apartment::findOrFail($id);
        $sponsorships = Sponsorship::all();
        return view('admin.apartments.sponsor', compact('apartment','sponsorships'));
    }

    public function pivot(Request $request)
    {
        $data = $request->all();
        $apartment = $data['apartment'];

        if (!isset($data['sponsorship'])) {
            return redirect()->route('admin.apartments.sponsor', $apartment)
                ->with('failure', 'Seleziona piano di sponsorizzazione');
        }

        $sponsorship = Sponsorship::findOrFail($data['sponsorship']);
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addDays($sponsorship->duration)->format('Y-m-d');
        $attached = $sponsorship->apartments()->attach($apartment, ['start_date' => $startDate, 'end_date' => $endDate]);

        return redirect()->route('admin.apartments.show', $apartment)
            ->with('success', 'Appartamento ' . $apartment . ' sponsorizzato correttamente.');
    }
}
