$(document).ready(function () {
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
});
