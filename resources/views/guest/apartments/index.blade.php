@extends('layouts.guest.app')
@section('main')
<main>
    <div class="section-one">
        <div class="search-bar">
            <form action="{{route('guest.apartments.search')}}" method="post">
                @csrf
                @method('GET')
                <div class="form-group">
                    <input type="search" id="address" name="address" placeholder="Where are you going?">
                    <input type="hidden" id="lat" name="lat" class="form-control">
                    <input type="hidden" id="lng" name="lng" class="form-control">
                    <div class="form-button">
                        <button class="btn-search" type="submit"><i class="fas fa-plane"></i></button>
                    </div>
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
                </div>
            </form>
        </div>
    </div>
    <div class="section-two">
        <div class="container">
            <div class="title">
                <h2>Dream your next trip</h2>
            </div>
            <div class="box">
                <div class="owl-carousel owl-theme">
                    @foreach ($apartments as $apartment)
                        <div class="card">
                            <img src="{{asset('storage/'. $apartment->main_img)}}" alt="{{$apartment->title}}">
                            <h3>{{$apartment->title}}</h3>
                            {{-- <p>{{$apartment->address}}</p> --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>






    <script src="{{asset('js/guest/owl.carousel.js')}}" type="text/javascript" src="" charset="utf-8"></script>
    <script src="{{asset('js/guest/main.js')}}" charset="utf-8"></script>
</main>
@endsection
