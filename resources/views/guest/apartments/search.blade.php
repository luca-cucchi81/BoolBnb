@extends('layouts.app')
@section('content')
    <form method="post">
        <div class="form-group">
            <fieldset>
                <legend>Aggiungi Criteri di Ricerca</legend>
                <input type="text" name="rooms" placeholder="Numero Minimo di Stanze">
                <input type="text" name="beds" placeholder="Numero Minimo di Posti Letto">
                <input type="text" name="radius" placeholder="Modifica raggio di ricerca">
                <input type="checkbox" id="wifi" name="services[]" value="wifi">
                <label for="wifi">wi-fi</label>
                <input type="checkbox" id="posto-auto" name="services[]" value="posto auto">
                <label for="posto-auto">posto auto</label>
                <input type="checkbox" id="piscina" name="services[]" value="piscina">
                <label for="piscina">piscina</label>
                <input type="checkbox" id="sauna" name="services[]" value="sauna">
                <label for="sauna">sauna</label>
                <input type="checkbox" id="vista-mare" name="services[]" value="vista mare">
                <label for="vista-mare">vista mare</label>
                <input type="checkbox" id="reception" name="services[]" value="portineria">
                <label for="reception">portineria</label>
                <button class="btn btn-primary m-3" type="submit">Vai</button>
            </fieldset>
        </div>
    </form>
    @foreach ($sponsoredApartments as $sponsored)
        <div class="result">
            <h2>{{$sponsored->title}}</h2>
            <img src="{{asset('storage/'. $sponsored->main_img)}}" alt="{{$sponsored->title}}">
            <div class="mark-lat d-none">{{$sponsored->lat}}</div>
            <div class="mark-lng d-none">{{$sponsored->lng}}</div>
        </div>
    @endforeach
    @foreach ($filteredApartments as $filtered)
        <div class="result">
            <h4>{{$filtered->title}}</h4>
            <img src="{{asset('storage/'. $filtered->main_img)}}" alt="{{$filtered->title}}">
            <div class="mark-lat d-none">{{$filtered->lat}}</div>
            <div class="mark-lng d-none">{{$filtered->lng}}</div>
        </div>
    @endforeach

    <div class="row">
        <input type="hidden" class='coord-lat' value="{{$dataLat}}">
        <input type="hidden" class='coord-lng' value="{{$dataLng}}">
        <input type="hidden" id="input-map" class="form-control">
    </div>

    <div class="row">
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
    <script>
        (function() {
            var latlng = {
                lat: $('.coord-lat').val(),
                lng: $('.coord-lng').val()
            };

            var apartments = [];

            $('.result').each(function(){
                var apartment = {};
                apartment.lat = $(this).find('.mark-lat').text();
                apartment.lng = $(this).find('.mark-lng').text();
                apartments.push(apartment);
            });

            var placesAutocomplete = places({
                appId: 'plLSMIJCIUJH',
                apiKey: 'e86892e02f2212ab0fc5e014822da6e2',
                container: document.querySelector('#input-map')
            }).configure({
                aroundLatLng: latlng.lat + ',' + latlng.lng,
                type: 'address'
            });

            var map = L.map('map', {
                scrollWheelZoom: true,
                zoomControl: true
            });

            var osmLayer = new L.TileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    minZoom: 1,
                    maxZoom: 19
                }
            );

            var markers = [];

            for (var i = 0; i < apartments.length; i++) {
                var apartment = apartments[i];
                addApartmentToMap(apartment);
            }

            map.setView(new L.LatLng(latlng.lat, latlng.lng), 13);
            map.addLayer(osmLayer);

            function addApartmentToMap(apartment) {
                var marker = L.marker({'lat': apartment.lat, 'lng': apartment.lng})
                marker.addTo(map);
                markers.push(marker);
            }
        })();
    </script>
@endsection
