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

    function createMessagesChart(id, labels, data) { // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
        var ctx = $(id);
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Tot. Messages',
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
                    label: 'Tot. Spent',
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
                    backgroundColor: ['lightblue', 'lightgreen', 'yellow', 'pink', 'orange', 'lightgrey', 'mediumpurple', 'olive', 'tomato', 'teal']
                }],
                labels: labels
            },
            options: {
                responsive: true
            }
        });
    };
});
