<div class="container">
    <div class="row">
        <div class="col-12">
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
        <form action="{{route('guest.apartments.search')}}" method="get">
            @csrf
            @method('GET')
            <div class="form-group">
                <input type="search" id="address" class="form-control" placeholder="Dove vuoi andare?">
                <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
                <script>
                    (function() {
                        var placesAutocomplete = places({
                            appId: 'plLSMIJCIUJH',
                            apiKey: 'e86892e02f2212ab0fc5e014822da6e2',
                            container: document.querySelector('#address')
                        });
                        var $address = document.querySelector('#address-value')
                        placesAutocomplete.on('change', function(e) {
                            $address.textContent = e.suggestion.value
                        });
                        placesAutocomplete.on('clear', function() {
                            $address.textContent = 'none';
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
