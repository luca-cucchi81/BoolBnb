$(document).ready(function () {
    $('#show-message').click(function(){ // Al click del bottone mostra messaggi appare la lista dei messaggi e il bottone nascondi
        $('#message-container').removeClass('d-none');
        $('#show-message').addClass('d-none');
        $('#hide-message').removeClass('d-none');
    });

    $('#hide-message').click(function(){ // Al click del bottone nascondi messaggi scompare la lista dei messaggi e compare il bottone mostra
        $('#message-container').addClass('d-none');
        $('#show-message').removeClass('d-none');
        $('#hide-message').addClass('d-none');
    });

    var apartmentId = $('#apartment_id').val(); // Assegno a una variabile l'id dell'appartamento e successivamente lo richiamo nell'url
    var visitsUrl = "http://127.0.0.1:8000/api/visits/apartment/" + apartmentId;

    apiCallGet();

    (function() { // Funzione di creazione Mapp
        var latlng = { // Oggetto con lat e lng presi dai due input nascosti
            lat: $('.coord-lat').val(),
            lng: $('.coord-lng').val()
        };

        var placesAutocomplete = places({
            appId: 'plLSMIJCIUJH',
            apiKey: 'e86892e02f2212ab0fc5e014822da6e2',
            container: document.querySelector('#input-map')
        }).configure({
            aroundLatLng: latlng.lat + ',' + latlng.lng,
            type: 'address'
        });

        var map = L.map('map', { // Controlli sullo zoom con la rotellina e barra di zoom
            scrollWheelZoom: false,
            zoomControl: true
        });

        var osmLayer = new L.TileLayer( // Impostazione zoom minimo e massimo
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                minZoom: 1,
                maxZoom: 19
            }
        );

        var markers = []; // Creazione array di markers per andare a inserire il marker nella pazza
        var marker = L.marker(latlng);
        marker.addTo(map);
        markers.push(marker);

        map.setView(new L.LatLng(latlng.lat, latlng.lng), 16); // Impostazione dello zoom ed epicentro inziale
        map.addLayer(osmLayer);
    })();

    function apiCallGet() {
        $.ajax({
            url: visitsUrl, // Url con id appartamento variabile
            method: 'GET',
            success: function (data) {
                var apartments = []; // creo due array vuoti che saranno label e data del grafico
                var visitsCount = [];
                for (var key in data) { // popolo questi due array con i valori dell'oggetto data, i labels con la chiave e i data con il valore corrispondente
                    apartments.push(key);
                    visitsCount.push(data[key]);
                }
                createVisitsChart('#visits-chart', apartments, visitsCount); // Richiamo funzione di creazione grafico con id, label e data in ingresso
            },
            error: function (err) {
                alert('errore API');
            }
        });
    }

    function createVisitsChart(id, labels, data) { // Funzione che crea un grafico tipo bar dato un id di destinazione e due array labels e data
        var ctx = $(id);
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Analisi Visite',
                    backgroundColor: 'lightgreen',
                    data: data,
                }],
                labels: labels,
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: { // Definisco l'asse delle Y con punto iniziale e dimensione degli step
                            beginAtZero: true,
                            stepSize: 10
                        }
                    }]
                }
            }
        });
    };
});
