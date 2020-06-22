@extends('layouts.guest.app')
@section('main')
<main>
    <div class="container">
        <div class="row">
            <div class="col-8">
                @foreach ($apartments as $apartment)
                    @foreach ($apartment->sponsorships as $sponsorship)
                            @if($sponsorship->price == $maxPrice)
                                <img src="{{$apartment->main_img}}" alt="{{$apartment->title}}">
                            @endif
                    @endforeach
                @endforeach
            </div>
        </div>
        <div class="row">
            <form action="{{route('guest.apartments.search')}}" method="post">
                @csrf
                @method('GET')
                <div class="form-group">
                    <input type="search" id="address" name="address" class="form-control" placeholder="Dove vuoi andare?">
                    <input type="hidden" id="lat" name="lat" class="form-control">
                    <input type="hidden" id="lng" name="lng" class="form-control">
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
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Vai</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
