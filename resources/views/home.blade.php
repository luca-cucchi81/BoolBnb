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

 <div class="chart col-6">
     <h2>Messaggi Ricevuti</h2>
     <canvas id="line-chart"></canvas>
 </div>
 <input type="hidden" id="user-id" value="{{$userId}}">

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/it.js" charset="utf-8"></script>
<script>
    $(document).ready(function () {

    var messagesUrl = "http://127.0.0.1:8000/api/messages";
    var apartmentsUrl = "http://127.0.0.1:8000/api/apartments";
    var apartmentsApi = [];

    $.ajax({
        url: apartmentsUrl,
        method: 'GET',
        success: function (data) {
            var userId = $('#user-id').val();
            for (var i = 0; i < data.length; i++) {
                var apartment = data[i];
                if (apartment.user_id == userId) {
                    apartmentsApi.push(apartment.id);
                }
            }
        },
        error: function (err) {
            alert('errore API');
        }
    });

    apiCallMessagesChart();

    function apiCallMessagesChart() {
        $.ajax({
            url: messagesUrl,
            method: 'GET',
            success: function (data) {
                var messages = {};
                 for (var i = 0; i < data.length; i++){
                     if (apartmentsApi.includes(data[i].apartment_id)) {
                         var message = data[i];
                         var apartmentId = message.apartment_id;
                         if (messages[apartmentId] === undefined){
                             messages[apartmentId] = 0;
                         }
                         messages[apartmentId] += 1;
                     }
                }
                var apartments = [];
                var messagesCount = [];
                for (var key in messages) {
                    apartments.push(key);
                    messagesCount.push(messages[key]);
                }
                createMessagesChart('#line-chart', apartments, messagesCount);
            },
            error: function (err) {
                alert('errore API');
            }
        });
    };

    function apiCallApartments() {
        $.ajax({
            url: apartmentsUrl,
            method: 'GET',
            success: function (data) {
                for (var i = 0; i < data.length; i++){
                    var apartmentId = data[i].id;
                    apartments.push(apartmentId);
                }
            },
            error: function (err) {
                alert('errore API');
            }
        });
    };


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
                    label: 'Numero di Messaggi relativi all\'appartamento',
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
});
</script>


@endsection
