<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Apartment;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::paginate(20);

        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.apartments.create');
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
        $data['slug'] = Str::slug($data['title'] , '-') . $now;

        if (!isset($data['visibility'])){
            $data['visibility'] = 0;
        } else {
            $data['visibility'] = 1;
        }

        $validator = Validator::make($data, [
            'title' => 'required|max:100',
            'description' => 'required',
            'rooms' => 'required|integer',
            'beds' => 'required|integer',
            'bathrooms' => 'required|integer',
            'square_meters' => 'required|integer',
            'address' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.apartmets.create')
                ->withErrors($validator)
                ->withInput();
        }

        $apartment = new Apartment;

        $apartment->fill($data);
        $saved = $apartment->save();

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
        return view('admin.apartments.show', compact('apartment'));
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
        $apartment = Apartment::findOrFail($id);

        $apartment->sponsorships()->detach();
        $apartment->services()->detach();
        $apartment->images()->delete();
        $apartment->messages()->delete();
        $apartment->views()->delete();

        $deleted = $apartment->delete();

        if(!$deleted){
            return redirect()->route('admin.apartments.index')
                ->with('failure', 'Appartamento ' . $apartment->id . ' non eliminato.');
        }

        return redirect()->route('admin.apartments.index')
            ->with('success', 'Appartamento ' . $apartment->id . ' eliminato correttamente.');
    }
}
