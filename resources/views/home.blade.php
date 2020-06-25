@extends('layouts.admin.app')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </nav>
        </div>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="stats-card dashboard-card col-3" id="stat-1">
            <div class="stats-sx">
                <h5>Messages Count</h5>
                <p>{{$messagesCount}}</p>
            </div>
            <div class="stats-dx">
                <i class="fas fa-comments"></i>
            </div>
        </div>
        <div class="stats-card dashboard-card col-3" id="stat-2">
            <div class="stats-sx">
                <h5>Visits Count</h5>
                <p>{{$visitsCount}}</p>
            </div>
            <div class="stats-dx">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stats-card dashboard-card col-3" id="stat-3">
            <div class="stats-sx">
                <h5>Sponsors Amount</h5>
                <p>€ {{$totalAmountSp}}</p>
            </div>
            <div class="stats-dx">
                <i class="fas fa-coins"></i>
            </div>
        </div>
        <div class="stats-card dashboard-card col-3" id="stat-4">
            <div class="stats-sx">
                <h5>Sponsors Count</h5>
                <p>{{$spnCount}}</p>
            </div>
            <div class="stats-dx">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="chart col-4">
            <h6 class="text-center">Messages Received for Each Apartment</h6>
            <canvas id="messages-chart"></canvas>
        </div>
        <div class="chart col-4">
            <h6 class="text-center">Visits for Each Apartment</h6>
            <canvas id="visits-chart"></canvas>
        </div>
        <div class="chart col-4">
            <h6 class="text-center">Total Amount for each Apartment</h6>
            <canvas id="sponsorships-chart"></canvas>
        </div>
    </div>

    <input type="hidden" id="user-id" value="{{$userId}}">
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/it.js" charset="utf-8"></script>
<script src="{{asset('js/admin/home.js')}}" charset="utf-8"></script>


@endsection
