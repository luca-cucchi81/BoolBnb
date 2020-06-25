@extends('layouts.admin.app')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('admin.apartments.index')}}">Apartments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$apartment->title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary m-3" href="{{route('admin.apartments.index')}}">&#8592; Back to Index</a>
                    </li>
                </ul>
                <div class="col-8 offset-2">
                    <form action="{{route('admin.apartments.update', $apartment->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <fieldset>
                                <legend>Apartment Name</legend>
                                <input type="text" name="title" class="form-control" value="{{old('title') ?? $apartment->title}}">
                                @error('title')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Description</legend>
                                <input type="text" name="description" class="form-control" value="{{old('description') ?? $apartment->description}}">
                                @error('description')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Rooms Amount</legend>
                                <input type="text" name="rooms" class="form-control" value="{{old('rooms') ?? $apartment->rooms}}">
                                @error('rooms')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Bedrooms Amount</legend>
                                <input type="text" name="beds" class="form-control" value="{{old('beds') ?? $apartment->beds}}">
                                @error('beds')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Bathrooms Amount</legend>
                                <input type="text" name="bathrooms" class="form-control" value="{{old('bathrooms') ?? $apartment->bathrooms}}">
                                @error('bathrooms')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Square Meters</legend>
                                <input type="text" name="square_meters" class="form-control" value="{{old('square_meters') ?? $apartment->square_meters}}">
                                @error('square_meters')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Address</legend>
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
                                <legend>Edit Main Photo</legend>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="main_img">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                                @error('main_img')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>

                        @if ($images->isEmpty())
                            <div class="form-group">
                                <fieldset>
                                    <legend>Upload more Photos</legend>
                                    @for ($i = 0; $i < 4; $i++)
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="secondary-photo-{{$i}}" name="images[]">
                                            <label class="custom-file-label" for="secondary-photo-{{$i}}">Choose file</label>
                                        </div>
                                    @endfor
                                </fieldset>
                            </div>
                        @endif
                        <script>
                            $('.custom-file-input').on('change',function(){
                            var fileName = $(this).val();
                            $(this).next('.custom-file-label').html(fileName);
                        });
                        </script>
                        <div class="form-group">
                            <fieldset>
                                <legend>Services</legend>
                                @foreach ($services as $service)
                                    <input type="checkbox" name="services[]" id="services-{{$service->id}}" value="{{$service->id}}" {{((is_array(old('services')) && in_array($service->id, old('services'))) ||  $apartment->services->contains($service->id)) ? 'checked' : ''}}>
                                    <label class="input-services" for="services-{{$service->id}}">{{$service->name}}</label>
                                @endforeach
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input name="visibility" type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                                <label class="custom-control-label" for="customSwitch1">Visible to Guests</label>
                            </div>
                            @error('visibility')
                                <span class="alert alert-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center final-button">
                            <input type="submit" value="Apply" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
