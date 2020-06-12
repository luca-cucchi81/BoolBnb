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
            <a class="btn btn-primary" href="{{route('admin.apartments.sponsor', $apartment->id)}}">SPONSORIZZA</a>
            <a class="btn btn-primary" href="{{route('admin.apartments.edit', $apartment->id)}}">MODIFICA</a>
        </div>
    </div>
@endsection
