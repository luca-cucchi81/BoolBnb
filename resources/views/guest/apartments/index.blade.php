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
                    @foreach ($arrayApartments as $apartment)
                        <div class="card">
                            <a href="{{route('guest.apartments.show', $apartment->slug)}}"><img src="{{asset('storage/'. $apartment->main_img)}}" alt="{{$apartment->title}}"></a>
                            <h3><a href="{{route('guest.apartments.show', $apartment->slug)}}">{{$apartment->title}}</a></h3>
                            <small>{{$apartment->address}}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="section-three">
        <div class="container">
            <div class="grid">
                <div class="title">
                    <h2>Our best destinations</h2>
                </div>
                <div class="gallery">
                    <div class="img">
                        <form action="{{route('guest.apartments.search')}}" method="post">
                            @csrf
                            @method('GET')
                            <input type="hidden" id="address" name="address" value="Roma, Lazio, Italia">
                            <input type="hidden" id="lat" name="lat" class="form-control" value="41.8948">
                            <input type="hidden" id="lng" name="lng" class="form-control" value="12.4853">
                            <button class="btn-search" type="submit"></button>
                        </form>
                        <img src="{{asset('img/roma.jpg')}}" alt="roma">
                        <div class="overlay hidden"><p>ROME</p></div>
                    </div>
                    <div class="img">
                        <form action="{{route('guest.apartments.search')}}" method="post">
                            @csrf
                            @method('GET')
                            <input type="hidden" id="address" name="address" value="Bologna, Emilia-Romagna, Italia">
                            <input type="hidden" id="lat" name="lat" class="form-control" value="44.4937">
                            <input type="hidden" id="lng" name="lng" class="form-control" value="11.343">
                            <button class="btn-search" type="submit"></button>
                        </form>
                        <img src="{{asset('img/bologna.jpg')}}" alt="bologna">
                        <div class="overlay hidden"><p>BOLOGNA</p></div>
                    </div>
                    <div class="img">
                        <form action="{{route('guest.apartments.search')}}" method="post">
                            @csrf
                            @method('GET')
                            <input type="hidden" id="address" name="address" value="Milano, Lombardia, Italia">
                            <input type="hidden" id="lat" name="lat" class="form-control" value="45.4668">
                            <input type="hidden" id="lng" name="lng" class="form-control" value="9.1905">
                            <button class="btn-search" type="submit"></button>
                        </form>
                        <img src="{{asset('img/milano.jpg')}}" alt="milano">
                        <div class="overlay hidden"><p>MILAN</p></div>
                    </div>
                    <div class="img">
                        <form action="{{route('guest.apartments.search')}}" method="post">
                            @csrf
                            @method('GET')
                            <input type="hidden" id="address" name="address" value="Venezia, Veneto, Italia">
                            <input type="hidden" id="lat" name="lat" class="form-control" value="45.4372">
                            <input type="hidden" id="lng" name="lng" class="form-control" value="12.3346">
                            <button class="btn-search" type="submit"></button>
                        </form>
                        <img src="{{asset('img/venezia.jpg')}}" alt="venezia">
                        <div class="overlay hidden"><p>VENICE</p></div>
                    </div>
                    <div class="img">
                        <form action="{{route('guest.apartments.search')}}" method="post">
                            @csrf
                            @method('GET')
                            <input type="hidden" id="address" name="address" value="Firenze, Toscana, Italia">
                            <input type="hidden" id="lat" name="lat" class="form-control" value="43.7698">
                            <input type="hidden" id="lng" name="lng" class="form-control" value="11.2555">
                            <button class="btn-search" type="submit"></button>
                        </form>
                        <img src="{{asset('img/firenze.jpg')}}" alt="firenze">
                        <div class="overlay hidden"><p>FLORENCE</p></div>
                    </div>
                    <div class="img">
                        <form action="{{route('guest.apartments.search')}}" method="post">
                            @csrf
                            @method('GET')
                            <input type="hidden" id="address" name="address" value="Palermo, Sicilia, Italia">
                            <input type="hidden" id="lat" name="lat" class="form-control" value="38.1112">
                            <input type="hidden" id="lng" name="lng" class="form-control" value="13.3524">
                            <button class="btn-search" type="submit"></button>
                        </form>
                        <img src="{{asset('img/palermo.jpg')}}" alt="palermo">
                        <div class="overlay hidden"><p>PALERMO</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.img').mouseenter(function(){
                $(this).find('.overlay').removeClass('hidden');
            });
            $('.img').mouseleave(function(){
                $(this).find('.overlay').addClass('hidden');
            });
        });
    </script>
    <script src="{{asset('js/guest/owl.carousel.js')}}" type="text/javascript" src="" charset="utf-8"></script>
    <script src="{{asset('js/guest/main.js')}}" charset="utf-8"></script>
</main>
@endsection
