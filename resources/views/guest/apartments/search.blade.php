@extends('layouts.app')
@section('content')
    <form action="{{route('guest.apartments.search')}}" method="post">
        @csrf
        @method('GET')
        <div class="form-group">
            <input type="search" id="address" name="address" class="form-control" placeholder="Cambia destinazione">
            <input type="hidden" id="lat" name="lat" class="form-control">
            <input type="hidden" id="lng" name="lng" class="form-control">
            <input type="hidden" id="old-address" name="oldAddress" class="form-control" value="{{$oldAddress}}">
            <input type="hidden" id="old-lat" name="oldLat" class="form-control" value="{{$oldLat}}">
            <input type="hidden" id="old-lng" name="oldLng" class="form-control" value="{{$oldLng}}">
        </div>
        <div class="form-group">
            <label for="radius">Modifica raggio di ricerca</label>
            <input type="number" id="radius" min="20" max="50" name="radius" value="20">
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Vai</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
    <script>
        (function() {
            var placesAutocomplete = places({
                appId: 'plLSMIJCIUJH',
                apiKey: 'e86892e02f2212ab0fc5e014822da6e2',
                container: document.querySelector('#address')
            });
            var address = document.querySelector('#address-value')
            placesAutocomplete.on('change', function(e) {
                $('#address').val(e.suggestion.value);  //ora è scritto bene
                $('#lat').val(e.suggestion.latlng.lat);
                $('#lng').val(e.suggestion.latlng.lng);

                console.log("latitudine: ", $('#lat').val());
                console.log("longitudine: ", $('#lng').val());
            });
            placesAutocomplete.on('clear', function() {
                //$address.textContent = 'none';
                $('#address').val('');
                $('#lat').val('');
                $('#lng').val('');
            });
        })();
    </script>
    <form>
        <div class="form-group">
            <fieldset>
                <legend>Aggiungi Criteri di Ricerca</legend>
                <label for="rooms">N° minimo di Stanze</label>
                <input type="number" id="rooms" min="1" max="9" name="rooms" value="1">
                <label for="beds">N° minimo di Posti Letto</label>
                <input type="number" id="beds" min="1" max="9" name="beds" value="1">
            </fieldset>
        </div>
        <div class="form-group">
            <fieldset>
                <legend>Filtra per Servizi</legend>
                @foreach ($services as $service)
                    <input type="checkbox" id='service-{{$service->id}}' class="check-filter" value="{{$service->id}}">
                    <label for="service-{{$service->id}}">{{$service->name}}</label>
                @endforeach
            </fieldset>
        </div>
        <div class="form-group">
            <button id="filtra" class="btn btn-primary m-3" type="button">Vai</button>
            <button id="clear" class="btn btn-primary m-3" type="button">Pulisci</button>
        </div>
    </form>
    @foreach ($sponsoredApartments as $sponsored)
        <div class="result">
            <h2><a href="{{route('guest.apartments.show', $sponsored->slug)}}">{{$sponsored->title}}</a></h2>
            <img src="{{asset('storage/'. $sponsored->main_img)}}" alt="{{$sponsored->title}}">
            <div class="mark-lat d-none">{{$sponsored->lat}}</div>
            <div class="mark-lng d-none">{{$sponsored->lng}}</div>
            <div class="rooms">{{$sponsored->rooms}}</div>
            <div class="beds">{{$sponsored->beds}}</div>
            @foreach ($sponsored->services as $service)
                <p class="services" data-service="{{$service->id}}">{{$service->name}}</p>
            @endforeach
        </div>
    @endforeach
    @foreach ($filteredApartments as $filtered)
        <div class="result">
            <h4><a href="{{route('guest.apartments.show', $filtered->slug)}}">{{$filtered->title}}</a></h4>
            <img src="{{asset('storage/'. $filtered->main_img)}}" alt="{{$filtered->title}}">
            <div class="mark-lat d-none">{{$filtered->lat}}</div>
            <div class="mark-lng d-none">{{$filtered->lng}}</div>
            <div class="rooms">{{$filtered->rooms}}</div>
            <div class="beds">{{$filtered->beds}}</div>
            @foreach ($filtered->services as $service)
                <p class="services" data-service="{{$service->id}}">{{$service->name}}</p>
            @endforeach
        </div>
    @endforeach

    <div class="row">
        <input type="hidden" class='coord-lat' value="{{$dataLat}}">
        <input type="hidden" class='coord-lng' value="{{$dataLng}}">
        <input type="hidden" id="input-map" class="form-control">
    </div>

    <div class="row" id="map-container">
        <div id="map"></div>
    </div>

    <style>
        #map {
            height: 400px;
            width: 600px;
        }
        svg {
            display: none;
        }
    </style>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src="https://cdn.jsdelivr.net/leaflet/1/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
    <script src="{{asset('js/guest/search.js')}}" charset="utf-8"></script>
@endsection
