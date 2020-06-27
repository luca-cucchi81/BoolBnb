@extends('layouts.guest.app')
@section('main')
<main>
    <div class="container">
        <div class="section-four">
            <div class="search-bar">
                <form action="{{route('guest.apartments.search')}}" method="post">
                    @csrf
                    @method('GET')
                    <div class="form-group">
                        <input type="search" id="address" name="address"  placeholder="Change destination">
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lng" name="lng">
                        <input type="hidden" id="old-address" name="oldAddress" value="{{$oldAddress}}">
                        <input type="hidden" id="old-lat" name="oldLat" value="{{$oldLat}}">
                        <input type="hidden" id="old-lng" name="oldLng" value="{{$oldLng}}">
                        <div class="form-button">
                            <label for="radius">Radius:</label>
                            <input type="number" id="radius" min="20" max="50" name="radius" value="20">
                            <button class="btn-search" type="submit"><i class="fas fa-plane"></i></button>
                        </div>
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
            </div>
        </div>
        <div class="section-five">
            <div class="container">
                <form>
                    <div class="form-group form-input">
                            <input type="number" id="rooms" min="1" max="9" name="rooms" value="1">
                            <label for="rooms">Rooms</label>
                            <input type="number" id="beds" min="1" max="9" name="beds" value="1">
                            <label for="beds">Beds</label>
                    </div>
                    <div class="form-group form-button">
                        <button id="filtra" type="button">Filter</button>
                        <button id="clear" type="button">Reset</button>
                    </div>
                    <div class="form-group form-services">
                            @foreach ($services as $service)
                                <div>
                                    <input type="checkbox" id='service-{{$service->id}}' class="check-filter" value="{{$service->id}}">
                                    <label for="service-{{$service->id}}">{{$service->name}}</label>
                                </div>
                            @endforeach
                    </div>
                </form>
            </div>
        </div>
        <div class="section-six">
            <div class="container">
                <div class="results">
                    @foreach ($sponsoredApartments as $sponsored)
                        <div class="result">
                            <a href="{{route('guest.apartments.show', $sponsored->slug)}}"><img src="{{asset('storage/'. $sponsored->main_img)}}" alt="{{$sponsored->title}}"></a>
                            <h3><a href="{{route('guest.apartments.show', $sponsored->slug)}}">{{$sponsored->title}}</a></h3>
                            <div class="mark-lat hidden">{{$sponsored->lat}}</div>
                            <div class="mark-lng hidden">{{$sponsored->lng}}</div>
                            <div class="rooms hidden">{{$sponsored->rooms}}</div>
                            <div class="beds hidden">{{$sponsored->beds}}</div>
                            <p class="address-result">{{$sponsored->address}}</p>
                            <div class="services">
                                @foreach ($sponsored->services as $service)
                                    <div class="service" data-service="{{$service->id}}">{!!$service->icon!!}</div>
                                @endforeach
                            </div>
                            <div class="awarded"><i class="fas fa-award"></i></div>
                        </div>
                    @endforeach
                    @foreach ($filteredApartments as $filtered)
                        <div class="result">
                            <a href="{{route('guest.apartments.show', $filtered->slug)}}"><img src="{{asset('storage/'. $filtered->main_img)}}" alt="{{$filtered->title}}"></a>
                            <h4><a href="{{route('guest.apartments.show', $filtered->slug)}}">{{$filtered->title}}</a></h4>
                            <div class="mark-lat hidden">{{$filtered->lat}}</div>
                            <div class="mark-lng hidden">{{$filtered->lng}}</div>
                            <div class="rooms hidden">{{$filtered->rooms}}</div>
                            <div class="beds hidden">{{$filtered->beds}}</div>
                            <p class="address-result">{{$filtered->address}}</p>
                            <div class="services">
                                @foreach ($filtered->services as $service)
                                    <div class="service" data-service="{{$service->id}}">{!!$service->icon!!}</div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="map">
                    <div class="hidden">
                        <input type="hidden" class='coord-lat' value="{{$dataLat}}">
                        <input type="hidden" class='coord-lng' value="{{$dataLng}}">
                        <input type="hidden" id="input-map" class="form-control">
                    </div>
                    <div class="row" id="map-container">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
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
    </div>
</main>

@endsection
