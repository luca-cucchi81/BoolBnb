@extends('layouts.admin.app')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Messages</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row" id="message-container">
            <table class="table table-striped">
                <thead class="table-success">
                    <tr>
                        <th class="text-center mobile-hidden">APARTMENT</th>
                        <th class="text-center">SENDER</th>
                        <th class="text-center">MESSAGE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($arrayMessages as $arrayMessage)
                        @foreach ($arrayMessage as $message)
                            <tr>
                                <td class="mobile-hidden">{{$message->apartment->title}}</td>
                                <td>{{$message->sender}}</td>
                                <td>{{$message->body}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
