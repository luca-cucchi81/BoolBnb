@extends('layouts.admin.app')
@section('main')
<div class="container">
    <div class="row menu-row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('admin.apartments.show', $apartment->id)}}">{{$apartment->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sponsorship</li>
                </ol>
            </nav>
        </div>
    </div>
    <form action={{route('admin.sponsorships.store')}} method="post">
        @csrf
        @method("POST")
        <div class="row payment-row">
        @foreach ($sponsorships as $sponsorship)
            <div class="col-12 col-md-4 card-container">
                <div class="spn-card text-center">
                    <h6 class="">€ {{$sponsorship["price"]}}</h6>
                    <p class="">{{$sponsorship["duration"]}} Day/s</p>
                    <input class="" type="radio" name="sponsorship" value="{{$sponsorship["id"]}}">
                </div>
            </div>
        @endforeach
        </div>
        <input type="hidden" name="apartment" value="{{$apartment->id}}">
        <div class="text-center final-button">
            <button type="submit" class="d-none btn btn-success" id="invia">Confirm Payment</button>
        </div>
    </form>
    <div class="row">
        <div class="col-10 offset-1 col-md-6 offset-md-3">
            <div id="dropin-container"></div>
            <div class="text-center final-button">
                <button id="submit-button" class="btn btn-secondary">Verify Payment Method</button>
            </div>
        </div>
    </div>
</div>
    <script src="{{asset('js/admin/sponsor.js')}}" charset="utf-8"></script>
@endsection
