@extends('layouts.admin.app')
@section('main')
    <div class="container">
        <div class="row menu-row">
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
        <div class="row button-show">
            <div class="v-50 mx-auto">
                @if ($hide == false)
                    <a class="btn btn-success" href="{{route('admin.sponsorships.show', $apartment->id)}}">SPONSORS</a>
                @endif
                <a class="btn btn-warning" href="{{route('admin.apartments.edit', $apartment->id)}}">EDIT</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-7">
                <h2>{{$apartment->title}}</h2>
                <p id="show-address"><span id="show-sqm">{{$apartment->square_meters}} sqm.</span> {{$apartment->address}}</p>
                <p id="show-description">{{$apartment->description}}</p>
                <span class="show-info">Rooms: {{$apartment->rooms}}</span>
                <span class="show-info">Beds: {{$apartment->beds}}</span>
                <span class="show-info">Bathrooms: {{$apartment->bathrooms}}</span>
                <div class="services">
                    @foreach ($apartment->services as $service)
                        <div class="service" data-service="{{$service->id}}">{!!$service->icon!!}{{$service->name}}</div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <img class="img-show-main" src="{{asset('storage/'. $apartment->main_img)}}" alt="{{$apartment->title}}">
            </div>
        </div>
        <div class="row">
            @foreach ($apartment->images as $image)
                <div class="col-6 col-sm-3">
                    <img class="img-show" src="{{asset('storage/'. $image->path)}}" alt="{{$apartment->title}}">
                </div>
            @endforeach
        </div>
        <div class="row">
            <input type="hidden" class='coord-lat' value="{{$apartment->lat}}">
            <input type="hidden" class='coord-lng' value="{{$apartment->lng}}">
            <input type="hidden" id="input-map" class="form-control">
            <input type="hidden" id="apartment_id" class='apartment' value="{{$apartment->id}}">
        </div>
        <div class="row statistics">
            <div class="chart col-12 col-lg-7">
                <h4 class="text-center">Visit Stats</h4>
                <canvas id="visits-chart"></canvas>
            </div>
            <div class="col-12 col-lg-5">
                <div class="stats-card" id="stat-1">
                    <div class="stats-sx">
                        <h5>Messages Count</h5>
                        <p>{{$apartment->messages->count()}}</p>
                    </div>
                    <div class="stats-dx">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
                <div class="stats-card" id="stat-2">
                    <div class="stats-sx">
                        <h5>Sponsorships Amount</h5>
                        <p>€ {{$total}}</p>
                    </div>
                    <div class="stats-dx">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
                <div class="stats-card" id="stat-3">
                    <div class="stats-sx">
                        <h5>Sponsorships Count</h5>
                        <p>{{$apartment->sponsorships->count()}}</p>
                    </div>
                    <div class="stats-dx">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="v-50 mx-auto">
                <button type="button" class="btn btn-primary" id="show-message">Show Messages</button>
                <button type="button" class="btn btn-primary d-none" id="hide-message">Hide Messages</button>
            </div>
        </div>
        <div class="row d-none" id="message-container">
            <table class="table table-striped">
                <thead class="table-success">
                    <tr>
                        <th class="text-center">SENDER</th>
                        <th class="text-center">MESSAGE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartment->messages as $message)
                    <tr>
                        <td>{{$message->sender}}</td>
                        <td>{{$message->body}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{asset('js/admin/show.js')}}" charset="utf-8"></script>
@endsection
