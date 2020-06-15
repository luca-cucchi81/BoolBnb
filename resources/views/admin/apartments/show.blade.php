@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('admin.apartments.index')}}">Appartamenti</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$apartment->title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <h2>{{$apartment->title}}</h2>
            <p id="address">{{$apartment->address}}</p>
            <img src="{{asset('storage/'. $apartment->main_img)}}" alt="{{$apartment->title}}">
        </div>
        <div class="row">
            <a class="btn btn-primary" href="{{route('admin.apartments.sponsor', $apartment->id)}}">SPONSORIZZA</a>
            <a class="btn btn-primary" href="{{route('admin.apartments.edit', $apartment->id)}}">MODIFICA</a>
        </div>
        <div class="row">
            <input type="hidden" class='coord-lat' value="{{$apartment->lat}}">
            <input type="hidden" class='coord-lng' value="{{$apartment->lng}}">
            <input type="hidden" id="input-map" class="form-control">
        </div>
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
            var marker = L.marker(latlng);
            marker.addTo(map);
            markers.push(marker);

            map.setView(new L.LatLng(latlng.lat, latlng.lng), 16);
            map.addLayer(osmLayer);
        })();
    </script>
@endsection
