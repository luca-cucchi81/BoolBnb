$(document).ready(function () {

    generateMap();
    clear();

    $('#filtra').click(function () {
        search();
    });

    $('#clear').click(function () {
        clear();
        search();
    });

    function clear() {
        $('#beds').val(1);
        $('#rooms').val(1);
        $('#radius').val(20);
        $('.check-filter').prop('checked', false);
    };

    function search(){
        var filters = filterscreate();

        var rooms = parseInt($('#rooms').val());
        var beds = parseInt($('#beds').val());
        $('.result').addClass('d-none');

        $('.result').each(function(){
            var apartmentRooms = parseInt($(this).find('.rooms').text());
            var apartmentBeds = parseInt($(this).find('.beds').text());
            var services = [];
            $(this).find('.services').each(function(){
                var service = $(this).data('service');
                services.push(service);
            });
            var check = isTrue(filters, services);

            if ((rooms <= apartmentRooms) && (beds <= apartmentBeds) && (check)) {
                $(this).removeClass('d-none');
            };
        });
        $('#map').remove();
        $('#map-container').html('<div id="map"></div>');
        generateMap();
    };

    function generateMap(){
        (function() {
            var latlng = {
                lat: $('.coord-lat').val(),
                lng: $('.coord-lng').val()
            };

            var apartments = [];

            $('.result[class="result"]').each(function(){
                var apartment = {};
                apartment.lat = $(this).find('.mark-lat').text();
                apartment.lng = $(this).find('.mark-lng').text();
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

            map.setView(new L.LatLng(latlng.lat, latlng.lng), 12);

            map.addLayer(osmLayer);


            function addApartmentToMap(apartment) {
                var marker = L.marker({'lat': apartment.lat, 'lng': apartment.lng})
                marker.addTo(map);
                markers.push(marker);
            }
        })();
    };

    function filterscreate() {
        var filters = [];
        $('.check-filter').each(function(){
            if ($(this).prop('checked') == true) {
                filters.push(parseInt($(this).val()));
            }
        });
        return filters;
    };

    function isTrue(arr, arr2){
        return arr.every(i => arr2.includes(i));
    };
});
