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

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/it.js" charset="utf-8"></script>
<script>
    $(document).ready(function () {

    var messagesUrl = "http://127.0.0.1:8000/api/messages";
    var apartmentsUrl = "http://127.0.0.1:8000/api/apartments";
    
    apiCallMessagesChart();
 
    function apiCallMessagesChart() {
        $.ajax({
            url: messagesUrl,
            method: 'GET',
            success: function (data) {
                var messages = {};
                 for (var i = 0; i < data.length; i++){
                   var message = data[i];
                   var apartmentId = message.apartment_id;
                   if (messages[apartmentId] === undefined){
                       messages[apartmentId] = 0;
                   }
                   messages[apartmentId] += 1;
                }

                var apartments = [];
                var messagesCount = [];
                for (var key in messages) {
                    apartments.push(key);
                    messagesCount.push(messages[key]);
                }
                console.log(apartments);
                console.log(messagesCount);
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

    function totalAmountBuilder(array) { // Funzione che con un array in entrata ritorna una variabile con valore l'Amount Totale
        var totalAmount = 0;
        for (var i = 0; i < array.length; i++) {
            var iObject = array[i];
            totalAmount += parseInt(iObject.amount);
        }
        return totalAmount;
    };

    function objectMonthBuilder(array) { // Funzione che con un array in entrata crea un oggetto per ritornare due array con mesi e vendite
        var objectMonth = { // Creazione oggetto con chiavi già fissate
            gennaio: 0,
            febbraio: 0,
            marzo: 0,
            aprile: 0,
            maggio: 0,
            giugno: 0,
            luglio: 0,
            agosto: 0,
            settembre: 0,
            ottobre: 0,
            novembre: 0,
            dicembre: 0,
        };
        for (var i = 0; i < array.length; i++) { // Ciclo sull'array GET per aggiungere a ogni mese dell'oggetto l'amount corrispondente
            var iObject = array[i];
            var iObjectDate = iObject.date;
            var month = moment(iObjectDate, 'DD/MM/YYYY').format('MMMM');
            objectMonth[month] += parseInt(iObject.amount);
        }
        var arrayLabels = []; // Inizializzo i due Array da utilizzare in Chart.js
        var arrayData = [];
        for (var key in objectMonth) { // Ciclo all'interno dell'oggetto per trasformare la coppia chiave-valore in due array da dare a Chart.js
            arrayLabels.push(key); // Inserisco il nome del mese nell'arrayLabels
            arrayData.push(objectMonth[key]); // Inserisco nell'arrayData la somma di tutte le vendite relative a quel mese
        }
        return {
            labels: arrayLabels,
            data: arrayData
        };
    };

    function objectSalesmanBuilder(array, totalAmount) { // Funzione che con un array in entrata crea un oggetto per ritornare due array con venditori e vendite
        var objectSalesman = {}; // Creazione oggetto vuoto
        for (var i = 0; i < array.length; i++) { // Ciclo sull'array GET per aggiungere i venditori all'oggetto e il rispettivo amount per ciascuno di essi
            var iObject = array[i];
            var salesman = iObject.salesman;
            if (objectSalesman[salesman] === undefined) {
                objectSalesman[salesman] = 0;
            }
            objectSalesman[salesman] += parseInt(iObject.amount);
        }
        var arrayLabels = []; // Inizializzo i due Array da utilizzare in Chart.js
        var arrayData = [];
        for (var key in objectSalesman) { // Ciclo all'interno dell'oggetto per trasformare la coppia chiave-valore in due array da dare a Chart.js
            arrayLabels.push(key); // Inserisco il nome del venditore nell'arrayLabels
            var salesmanAmountPerc = ((objectSalesman[key] / totalAmount) * 100).toFixed(2); // Assegno a una variabile il venduto in percentuale
            arrayData.push(salesmanAmountPerc); // Inserisco nell'arrayData la somma di tutte le vendite relative a quel venditore
        }
        return {
            labels: arrayLabels,
            data: arrayData
        };
    };

    function objectQuarterBuilder(array) { // Funzione che con un array in entrata crea un oggetto per ritornare due array con mesi e vendite
        var objectQuarter = {}; // Creazione oggetto vuoto
        for (var i = 0; i < array.length; i++) { // Ciclo sull'array GET per aggiungere a ogni mese dell'oggetto l'amount corrispondente
            var iObject = array[i];
            var iObjectDate = iObject.date;
            var quarter = moment(iObjectDate, 'DD/MM/YYYY').quarter();
            if (objectQuarter[quarter] === undefined) {
                objectQuarter[quarter] = 0;
            }
            objectQuarter[quarter] += parseInt(iObject.amount);
        }
        var arrayLabels = []; // Inizializzo i due Array da utilizzare in Chart.js
        var arrayData = [];
        for (var key in objectQuarter) { // Ciclo all'interno dell'oggetto per trasformare la coppia chiave-valore in due array da dare a Chart.js
            arrayLabels.push(key); // Inserisco il nome del mese nell'arrayLabels
            arrayData.push(objectQuarter[key]); // Inserisco nell'arrayData la somma di tutte le vendite relative a quel mese
        }
        return {
            labels: arrayLabels,
            data: arrayData
        };
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
            type: 'line',
            data: {
                datasets: [{
                    label: 'Messaggi Ricevuti per ogni appartamento',
                    borderColor: 'darkblue',
                    lineTension: 0.5,
                    data: data,
                }],
                labels: labels,
            },
        });
    };
});
</script>


@endsection
