@extends('layouts.app')
@section('content')
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a class="btn btn-primary" href="{{route('admin.apartments.index')}}">Vai agli Appartamenti</a>
                    <a class="btn btn-primary" href="{{route('admin.messages.index')}}">Vai ai messaggi</a>

                </div>
            </div>
        </div>
    </div>
</div>

 <div class="chart col-4">
     <h2 class="text-center">Messaggi Ricevuti per Appartamento</h2>
     <canvas id="messages-chart"></canvas>
 </div>
 <div class="chart col-4">
     <h2 class="text-center">Visite per Appartamento</h2>
     <canvas id="visits-chart"></canvas>
 </div>
 <div class="chart col-4">
     <h2 class="text-center">Totale speso per Sponsorizzazioni per Appartamento</h2>
     <canvas id="sponsorships-chart"></canvas>
 </div>
 <input type="hidden" id="user-id" value="{{$userId}}">

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/it.js" charset="utf-8"></script>
<script>
    $(document).ready(function () {

    var userId = $('#user-id').val();
    var messagesUrl = "http://127.0.0.1:8000/api/messages/" + userId;
    var visitsUrl = "http://127.0.0.1:8000/api/visits/" + userId;
    var sponsorshipsUrl = "http://127.0.0.1:8000/api/sponsorships/" + userId;

    apiCallMessagesChart();
    apiCallVisitsChart();
    apiCallSponsorshipsChart();

    function apiCallSponsorshipsChart() {
        $.ajax({
            url: sponsorshipsUrl,
            method: 'GET',
            success: function (data) {
                var apartments = [];
                var sponsorshipsCount = [];
                for (var key in data) {
                    apartments.push(key);
                    sponsorshipsCount.push(data[key]);
                }
                createSponsorshipsChart('#sponsorships-chart', apartments, sponsorshipsCount);
            },
            error: function (err) {
                alert('errore API');
            }
        });
    };

    function apiCallMessagesChart() {
        $.ajax({
            url: messagesUrl,
            method: 'GET',
            success: function (data) {
                var apartments = [];
                var messagesCount = [];
                for (var key in data) {
                    apartments.push(key);
                    messagesCount.push(data[key]);
                }
                createMessagesChart('#messages-chart', apartments, messagesCount);
            },
            error: function (err) {
                alert('errore API');
            }
        });
    };

    function apiCallVisitsChart() {
        $.ajax({
            url: visitsUrl,
            method: 'GET',
            success: function (data) {
                var apartments = [];
                var visitsCount = [];
                for (var key in data) {
                    apartments.push(key);
                    visitsCount.push(data[key]);
                }
                createVisitsChart('#visits-chart', apartments, visitsCount);
            },
            error: function (err) {
                alert('errore API');
            }
        });
    }

    function createLineChart(id, labels, data) { // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
        var ctx = $(id);
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Vendite Mensili',
                    borderColor: 'darkblue',
                    lineTension: 0,
                    data: data
                }]
            }
        });
    };

    function createBarChart(id, labels, data) { // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
        var ctx = $(id);
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Vendite Trimestrali',
                    backgroundColor: 'darkred',
                    data: data
                }]
            }
        });
    };

    function createPieChart(id, labels, data) { // Funzione che crea un grafico tipo pie dato un id di destinazione e due array labels e data
        var ctx = $(id);
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: ['pink', 'orange', 'lightblue', 'lightgreen']
                }],
                labels: labels
            },
            options: {
                responsive: true,
                tooltips: {
                  callbacks: {
                    label: function(tooltipItem, data) {
                      return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '%';
                    }
                  }
                }
            }
        });
    };

    function createMessagesChart(id, labels, data) { // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
        var ctx = $(id);
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Tot. Messaggi',
                    backgroundColor: '#ff6666',
                    data: data,
                }],
                labels: labels,
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                }
            }
        });
    };

    function createSponsorshipsChart(id, labels, data) { // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
        var ctx = $(id);
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Tot. Speso',
                    backgroundColor: 'lightgreen',
                    data: data,
                }],
                labels: labels,
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 10
                        }
                    }]
                }
            }
        });
    };

    function createVisitsChart(id, labels, data) { // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
        var ctx = $(id);
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: ['lightblue', 'lightgreen', 'yellow', 'pink']
                }],
                labels: labels
            },
            options: {
                responsive: true
            }
        });
    };
});
</script>


@endsection
