@extends('layouts.app')
@section('content')
    <form>
        <div class="form-group">
            <fieldset>
                <legend>Aggiungi Criteri di Ricerca</legend>
                <label for="rooms">N° minimo di Stanze</label>
                <input type="number" id="rooms" min="1" max="9" name="rooms" value="1">
                <label for="beds">N° minimo di Posti Letto</label>
                <input type="number" id="beds" min="1" max="9" name="beds" value="1">
                <label for="radius">Modifica raggio di ricerca</label>
                <input type="number" id="radius" min="20" max="50" name="radius" value="20">
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
            <h2>{{$sponsored->title}}</h2>
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
            <h4>{{$filtered->title}}</h4>
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
    <script>
        $(document).ready(function () {
            clear();
            
            $('#filtra').click(function () {
                search();
            });

            $('#clear').click(function () {
                clear();
                search();
            });

            function clear() {
                $('#beds').val(1);
                $('#rooms').val(1);
                $('#radius').val(20);
                $('.check-filter').prop('checked', false);
            };

            function creafiltri() {
                var filters = [];
                $('.check-filter').each(function(){
                    if ($(this).prop('checked') == true) {
                        filters.push(parseInt($(this).val()));
                    }
                });
                return filters;
            };

            function isTrue(arr, arr2){
                return arr.every(i => arr2.includes(i));
            };

            function search(){
                var filters = creafiltri();

                var rooms = parseInt($('#rooms').val());
                var beds = parseInt($('#beds').val());
                $('.result').addClass('d-none');

                $('.result').each(function(){
                    var apartmentRooms = parseInt($(this).find('.rooms').text());
                    var apartmentBeds = parseInt($(this).find('.beds').text());
                    var services = [];
                    $(this).find('.services').each(function(){
                        var service = $(this).data('service');
                        services.push(service);
                    });
                    var check = isTrue(filters, services);

                    if ((rooms <= apartmentRooms) && (beds <= apartmentBeds) && (check)) {
                        $(this).removeClass('d-none');
                    };
                });
            }
        });
    </script>
@endsection
