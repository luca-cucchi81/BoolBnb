@extends('layouts.admin.app')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('admin.apartments.index')}}">Apartments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Insert a new Apartment</li>
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
                    <form action="{{route('admin.apartments.store')}}" method="POST" enctype="multipart/form-data" class="md-form">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <fieldset>
                                <legend>Apartment Name</legend>
                                <input type="text" name="title" class="form-control" value="{{old('title')}}">
                                @error('title')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Description</legend>
                                <textarea class="form-control" name="description" rows="4" value="{{old('description')}}"></textarea>
                                @error('description')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Rooms Amount</legend>
                                <input type="number" min='1' max='9' name="rooms" class="form-control" value="{{old('rooms')}}">
                                @error('rooms')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Beds Amount</legend>
                                <input type="number" min='1' max='9' name="beds" class="form-control" value="{{old('beds')}}">
                                @error('beds')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Bathrooms Amount</legend>
                                <input type="number" min='1' max='9' name="bathrooms" class="form-control" value="{{old('bathrooms')}}">
                                @error('bathrooms')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Square Meters</legend>
                                <input type="number" min='30' max='999' name="square_meters" class="form-control" value="{{old('square_meters')}}">
                                @error('square_meters')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Address</legend>
                                <input type="text" id="address" name="address" class="form-control" value="{{old('address')}}">
                                @error('address')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
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
                                <legend>Upload Main Photo</legend>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile04" name="main_img">
                                    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                    <script>
                                        $('#inputGroupFile04').on('change',function(){
                                        var fileName = $(this).val();
                                        $(this).next('.custom-file-label').html(fileName);
                                    });
                                    </script>
                                </div>
                                @error('main_img')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Services</legend>
                                @foreach ($services as $service)
                                    <input type="checkbox" name="services[]" id="services-{{$service->id}}" value="{{$service->id}}" {{(is_array(old('services')) && in_array($service->id, old('services'))) ? 'checked' : ''}}>
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
                            <input type="submit" value="Create" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
