$(document).ready(function () {
    var apartmentId = $('#apartment_id').val();
    var visitsUrl = "http://127.0.0.1:8000/api/visits/apartment/" + apartmentId;

    $.ajax({
        url: visitsUrl,
        method: 'GET',
        success: function (data) {
            console.log(data);
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

    function createVisitsChart(id, labels, data) { // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
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
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                }
            }
        });
    };

    (function() {
        var latlng = {
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

        var map = L.map('map', {
            scrollWheelZoom: false,
            zoomControl: true
        });

        var osmLayer = new L.TileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                minZoom: 1,
                maxZoom: 19
            }
        );

        var markers = [];
        var marker = L.marker(latlng);
        marker.addTo(map);
        markers.push(marker);

        map.setView(new L.LatLng(latlng.lat, latlng.lng), 16);
        map.addLayer(osmLayer);
    })();

    $('#show-message').click(function(){
        $('#message-container').removeClass('d-none');
        $('#show-message').addClass('d-none');
        $('#hide-message').removeClass('d-none');
    });

    $('#hide-message').click(function(){
        $('#message-container').addClass('d-none');
        $('#show-message').removeClass('d-none');
        $('#hide-message').addClass('d-none');
    });
});
