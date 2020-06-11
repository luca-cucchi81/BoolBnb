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
            <img src="{{asset('storage/'. $apartment->main_img)}}" alt="{{$apartment->title}}">
        </div>
        <div class="row">
            <button type="button" id="sponsorship" class="btn btn-primary">SPONSORIZZA</button>
            <div class="sponsor">
                <form class="" action="" method="post">
                    @csrf
                    @method('POST')
                    <label for="radio1">Ricco</label>
                        <input type="radio" id="radio1" name="service" value="">
                    <label for="radio2">Medio</label>
                        <input type="radio" id="radio2" name="service" value="">
                    <label for="radio3">Povero</label>
                        <input type="radio" id="radio3" name="service" value="">
                    <button class="btn btn-primary" type="submit" name="button">PAGA</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sponsorship').click(function () {
                $('.sponsor').toggleClass('visible');
            });
        });
    </script>
@endsection
