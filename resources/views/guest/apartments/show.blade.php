@extends('layouts.app')
@section('content')
    <h1>{{$apartment->title}}</h1>
    <img src="{{asset('storage/'. $apartment->main_img)}}" alt="{{$apartment->title}}">
    @if (Auth::id() != $apartment->user_id)
        <form class="form" action="{{route('guest.apartments.store')}}" method="post">
            @csrf
            @method('POST')
            <div class="form-group">
                <fieldset>
                    <legend>Mittente</legend>
                    <input type="email" name="sender" value="{{$userEmail}}" placeholder="Inserisci la tua e-mail">
                    @error('sender')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                </fieldset>
            </div>
            <div class="form-group">
                <fieldset>
                    <legend>Testo del messaggio</legend>
                    <textarea name="body" rows="8"></textarea>
                    @error('body')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                </fieldset>
            </div>
            <div class="form-group">
                <input name="apartment_id" type="hidden" class='apartment-id' value="{{$apartment->id}}">
                <button class="btn btn-primary" type="submit">CREA</button>
            </div>
        </form>
    @endif

    <div class="row">
        <input type="hidden" class='coord-lat' value="{{$apartment->lat}}">
        <input type="hidden" class='coord-lng' value="{{$apartment->lng}}">
        <input type="hidden" id="input-map" class="form-control">
    </div>
    <div class="row">
        <div id="map"></div>
    </div>
    <div>Visite del giorno: {{visits($apartment)->period('day')->count()}}</div>
    <div>Visite del mese: {{visits($apartment)->period('month')->count()}}</div>
    <div>Visite dell'anno: {{visits($apartment)->period('year')->count()}}</div>
    <div>Visite totali: {{visits($apartment)->count()}}</div>
    <style>
        #map {
            height: 400px;
            width: 600px;
        }
    </style>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src="https://cdn.jsdelivr.net/leaflet/1/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
    <script>
        (function() {
            var latlng = {
                lat: $('.coord-lat').val(),
                lng: $('.coord-lng').val()
            };

            var placesAutocomplete = places({
                appId: 'plLSMIJCIUJH',
                apiKey: 'e86892e02f2212ab0fc5e014822da6e2',
                container: document.querySelector('#input-map')
            }).configure({
                aroundLatLng: latlng.lat + ',' + latlng.lng,
                type: 'address'
            });

            var map = L.map('map', {
                scrollWheelZoom: false,
                zoomControl: true
            });

            var osmLayer = new L.TileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    minZoom: 1,
                    maxZoom: 19
                }
            );

            var markers = [];
            var marker = L.marker(latlng);
            marker.addTo(map);
            markers.push(marker);

            map.setView(new L.LatLng(latlng.lat, latlng.lng), 16);
            map.addLayer(osmLayer);
        })();
    </script>
@endsection
