@extends('layouts.app')
@section('content')
    @foreach ($apartments as $apartment)
        @foreach ($apartment->sponsorships as $sponsorship)
              @if ($sponsorship->price == '84')
                <h3>{{$apartment->title}}</h3>
              @endif
        @endforeach
    @endforeach
@endsection