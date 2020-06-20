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
            @if ($hide == false)
                <a class="btn btn-primary" href="{{route('admin.sponsorships.show', $apartment->id)}}">SPONSORIZZA</a>
            @endif
            <a class="btn btn-primary" href="{{route('admin.apartments.edit', $apartment->id)}}">MODIFICA</a>
        </div>
        <div class="row">
            <input type="hidden" class='coord-lat' value="{{$apartment->lat}}">
            <input type="hidden" class='coord-lng' value="{{$apartment->lng}}">
            <input type="hidden" id="input-map" class="form-control">
            <input type="hidden" id="apartment_id" class='apartment' value="{{$apartment->id}}">
        </div>
    </div>
    <div class="row">
        <div id="map"></div>
    </div>
    <button type="button" class="btn btn-primary" id="show-message">MOSTRA MESSAGGI</button>
    <button type="button" class="btn btn-primary d-none" id="hide-message">NASCONDI MESSAGGI</button>
    <div class="d-none" id="message-container">
        @foreach ($apartment->messages as $message)
            <div>
                <p>{{$apartment->title}}</p>
                <p>{{$message->sender}}</p>
                <p>{{$message->body}}</p>
            </div>
        @endforeach
    </div>
    <div class="chart col-4">
        <h2 class="text-center">Statistiche Visualizzazioni</h2>
        <canvas id="visits-chart"></canvas>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/leaflet/1/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
    <script>
        $(document).ready(function () {
            var apartmentId = $('#apartment_id').val();
            var visitsUrl = "http://127.0.0.1:8000/api/visits/apartment/" + apartmentId;

            $.ajax({
                url: visitsUrl,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    var apartments = [];
                    var visitsCount = [];
                    for (var key in data) {
                        apartments.push(key);
                        visitsCount.push(data[key]);
                    }
                    createVisitsChart('#visits-chart', apartments, visitsCount);
                },
                error: function (err) {
                    alert('errore API');
                }
            });

            function createVisitsChart(id, labels, data) { // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
                var ctx = $(id);
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        datasets: [{
                            label: 'Analisi Visite',
                            backgroundColor: 'lightgreen',
                            data: data,
                        }],
                        labels: labels,
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1
                                }
                            }]
                        }
                    }
                });
            };

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

            $('#show-message').click(function(){
                $('#message-container').removeClass('d-none');
                $('#show-message').addClass('d-none');
                $('#hide-message').removeClass('d-none');
            });

            $('#hide-message').click(function(){
                $('#message-container').addClass('d-none');
                $('#show-message').removeClass('d-none');
                $('#hide-message').addClass('d-none');
            });
        });
    </script>
@endsection
