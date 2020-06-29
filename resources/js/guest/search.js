$(document).ready(function () {

    generateMap();
    clear();

    $('#filtra').click(function () { // Al click del bottone di invio filtri parte la funzione di ricerca
        search();
    });

    $('#clear').click(function () { // Al click del bottone di pulizia filtri prima resetto tutto e poi faccio una ricerca
        clear();
        search();
    });

    function clear() { // Funzione di pulizia che riporta tutti gli input ai valori di default
        $('#beds').val(1);
        $('#rooms').val(1);
        $('.check-filter').prop('checked', false);
    };

    function search(){
        var filters = filterscreate(); // Richiamo di funzione di creazione array filtri

        var rooms = parseInt($('#rooms').val()); // Prendo i valori degli input per letti e stanze
        var beds = parseInt($('#beds').val());
        $('.result').addClass('hidden'); // Nascondo tutti gli appartamenti

        $('.result').each(function(){ // Per ogni appartamento
            var apartmentRooms = parseInt($(this).find('.rooms').text()); // Prendo i suoi valori di letti e stanze
            var apartmentBeds = parseInt($(this).find('.beds').text());
            var services = []; // Creo un array con i suoi servizi
            $(this).find('.service').each(function(){
                var service = $(this).data('service');
                services.push(service);
            });
            var check = isTrue(filters, services); // Richiamo funzione di intersezione tra due array

            if ((rooms <= apartmentRooms) && (beds <= apartmentBeds) && (check)) { // Se l'appartamento soddisfa tutti i criteri della ricerca lo visualizzo
                $(this).removeClass('hidden');
            };
        });
        $('#map').remove(); // Rimuovo e reinserisco la mappa per aggiornare tutti i markers
        $('#map-container').html('<div id="map"></div>');
        generateMap();
    };

    function generateMap(){ // Solita funzione di generazione mappa con markerr, epicentro e controllo zoom
        (function() {
            var latlng = {
                lat: $('.coord-lat').val(),
                lng: $('.coord-lng').val()
            };

            var apartments = [];

            $('.result[class="result"]').each(function(){ // Ciclo su ogni appartamento che sia visibile quindi con una sola classe
                var apartment = {}; // Popolazione oggetto con lat e lng per ogni appartamento
                apartment.lat = $(this).find('.mark-lat').text();
                apartment.lng = $(this).find('.mark-lng').text();
                apartment.title = $(this).find('.mark-title').text();
                apartments.push(apartment);
            });

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

            for (var i = 0; i < apartments.length; i++) {
                var apartment = apartments[i];
                addApartmentToMap(apartment);
            }

            if ($('#radius').val() == 20) {
                map.setView(new L.LatLng(latlng.lat, latlng.lng), 13);
            } else if ($('#radius').val() > 20 && $('#radius').val() <= 40) {
                map.setView(new L.LatLng(latlng.lat, latlng.lng), 12);
            } else if ($('#radius').val() > 40 && $('#radius').val() <= 50) {
                map.setView(new L.LatLng(latlng.lat, latlng.lng), 11);
            }

            map.addLayer(osmLayer);

            function addApartmentToMap(apartment) { // Aggiungo tutti i markers alla Mappa
                var marker = L.marker({'lat': apartment.lat, 'lng': apartment.lng})
                marker.addTo(map).bindPopup(apartment.title).openPopup();
                markers.push(marker);
            }

            // $('#radius').setAttribute('value', $('#radius').value);
        })();
    };

    function filterscreate() { // Funzione che crea un array filters inserendo i valori delle checkbox che sono stati cliccati dall'utente
        var filters = [];
        $('.check-filter').each(function(){
            if ($(this).prop('checked') == true) {
                filters.push(parseInt($(this).val()));
            }
        });
        return filters;
    };

    function isTrue(arr, arr2){ // Funzione che dati due array in ingresso controlla se il secondo array ha almeno un valore in comune con il primo array
        return arr.every(i => arr2.includes(i)); // Restituisce un booleano
    };
});
