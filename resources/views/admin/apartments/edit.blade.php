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
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary m-3" href="{{route('admin.apartments.index')}}">&#8592; Annulla modifica</a>
                    </li>
                </ul>
                <div class="col-8 offset-2">
                    <form action="{{route('admin.apartments.update', $apartment->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <fieldset>
                                <legend>Nome Appartamento</legend>
                                <input type="text" name="title" class="form-control" value="{{old('title') ?? $apartment->title}}">
                                @error('title')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Descrizione</legend>
                                <input type="text" name="description" class="form-control" value="{{old('description') ?? $apartment->description}}">
                                @error('description')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Numero Stanze</legend>
                                <input type="text" name="rooms" class="form-control" value="{{old('rooms') ?? $apartment->rooms}}">
                                @error('rooms')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Numero Letti</legend>
                                <input type="text" name="beds" class="form-control" value="{{old('beds') ?? $apartment->beds}}">
                                @error('beds')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Numero Bagni</legend>
                                <input type="text" name="bathrooms" class="form-control" value="{{old('bathrooms') ?? $apartment->bathrooms}}">
                                @error('bathrooms')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Metri Quadrati</legend>
                                <input type="text" name="square_meters" class="form-control" value="{{old('square_meters') ?? $apartment->square_meters}}">
                                @error('square_meters')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Indirizzo</legend>
                                <input id="address" type="text" name="address" class="form-control" value="{{old('address') ?? $apartment->address}}">
                                @error('address')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                                <input type="hidden" id="lat" name="lat" class="form-control" value="{{$apartment->lat}}">
                                <input type="hidden" id="lng" name="lng" class="form-control" value="{{$apartment->lng}}">
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
                                            $('#address').val(e.suggestion.value);  //ora è scritto bene
                                            $('#lat').val(e.suggestion.latlng.lat);
                                            $('#lng').val(e.suggestion.latlng.lng);
                                        });
                                        placesAutocomplete.on('clear', function() {
                                            //$address.textContent = 'none';
                                            $('#address').val('');
                                            $('#lat').val('');
                                            $('#lng').val('');
                                        });
                                    })();
                                </script>
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Modifica Foto di Copertina</legend>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="main_img">
                                    <label class="custom-file-label" for="inputGroupFile01"></label>
                                </div>
                                @error('main_img')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>

                        @if ($images->isEmpty())
                            <div class="form-group">
                                <fieldset>
                                    <legend>Carica ulteriori foto</legend>
                                    @for ($i = 0; $i < 4; $i++)
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="secondary-photo-{{$i}}"></label>
                                            <input type="file" class="custom-file-input" id="secondary-photo-{{$i}}" name="images[]">
                                        </div>
                                    @endfor
                                </fieldset>
                            </div>
                        @endif

                        <div class="form-group">
                            <fieldset>
                                <legend>Servizi</legend>
                                @foreach ($services as $service)
                                    <label for="services-{{$service->id}}">{{$service->name}}</label>
                                    <input type="checkbox" name="services[]" id="services-{{$service->id}}" value="{{$service->id}}" {{((is_array(old('services')) && in_array($service->id, old('services'))) ||  $apartment->services->contains($service->id)) ? 'checked' : ''}}>
                                @endforeach
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input name="visibility" type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                                <label class="custom-control-label" for="customSwitch1">Visibile a tutti</label>
                            </div>
                            @error('visibility')
                                <span class="alert alert-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <input type="submit" value="Invia" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
