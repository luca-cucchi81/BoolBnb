@extends('layouts.app')
@section('content')
    @foreach ($apartments as $apartment)
        @foreach ($apartment->messages as $message)
        <div>
            <p>{{$apartment->title}}</p>
            <p>{{$message->sender}}</p>
            <p>{{$message->body}}</p>
        </div>
            
        @endforeach
    @endforeach

@endsection