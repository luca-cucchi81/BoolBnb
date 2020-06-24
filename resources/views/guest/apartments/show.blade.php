@extends('layouts.guest.app')
@section('main')
<main>
    <div class="section-seven">
        <div class="container">
            <div class="show-sx">
                <h2>{{$apartment->title}}</h2>
                <p id="show-address"><span id="show-sqm">{{$apartment->square_meters}} sqm.</span> {{$apartment->address}}</p>
                <p id="show-description">{{$apartment->description}}</p>
                <span class="show-info">Rooms: {{$apartment->rooms}}</span>
                <span class="show-info">Beds: {{$apartment->beds}}</span>
                <span class="show-info">Bathrooms: {{$apartment->bathrooms}}</span>
                <div class="services">
                    @foreach ($apartment->services as $service)
                        <div class="service" data-service="{{$service->id}}">{!!$service->icon!!}{{$service->name}}</div>
                    @endforeach
                </div>
            </div>
            <div class="show-dx">
                @foreach ($apartment->images as $image)
                    <div class="card">
                        <img src="{{asset('storage/'. $image->path)}}" alt="{{$apartment->title}}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
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
                <input name="slug" type="hidden" class='slug' value="{{$apartment->slug}}">
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
    <style>
        #map {
            height: 400px;
            width: 600px;
        }
    </style>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src="https://cdn.jsdelivr.net/leaflet/1/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
    <script src="{{asset('js/guest/show.js')}}" charset="utf-8"></script>
    <script src="{{asset('js/guest/owl.carousel.js')}}" type="text/javascript" src="" charset="utf-8"></script>
    <script src="{{asset('js/guest/main.js')}}" charset="utf-8"></script>
</main>
@endsection
