/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin/show.js":
/*!************************************!*\
  !*** ./resources/js/admin/show.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('#show-message').click(function () {
    // Al click del bottone mostra messaggi appare la lista dei messaggi e il bottone nascondi
    $('#message-container').removeClass('d-none');
    $('#show-message').addClass('d-none');
    $('#hide-message').removeClass('d-none');
  });
  $('#hide-message').click(function () {
    // Al click del bottone nascondi messaggi scompare la lista dei messaggi e compare il bottone mostra
    $('#message-container').addClass('d-none');
    $('#show-message').removeClass('d-none');
    $('#hide-message').addClass('d-none');
  });
  var apartmentId = $('#apartment_id').val(); // Assegno a una variabile l'id dell'appartamento e successivamente lo richiamo nell'url

  var visitsUrl = "http://127.0.0.1:8000/api/visits/apartment/" + apartmentId;
  apiCallGet();

  (function () {
    // Funzione di creazione Mapp
    var latlng = {
      // Oggetto con lat e lng presi dai due input nascosti
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
      // Controlli sullo zoom con la rotellina e barra di zoom
      scrollWheelZoom: false,
      zoomControl: true
    });
    var osmLayer = new L.TileLayer( // Impostazione zoom minimo e massimo
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      minZoom: 1,
      maxZoom: 19
    });
    var markers = []; // Creazione array di markers per andare a inserire il marker nella pazza

    var marker = L.marker(latlng);
    marker.addTo(map);
    markers.push(marker);
    map.setView(new L.LatLng(latlng.lat, latlng.lng), 16); // Impostazione dello zoom ed epicentro inziale

    map.addLayer(osmLayer);
  })();

  function apiCallGet() {
    $.ajax({
      url: visitsUrl,
      // Url con id appartamento variabile
      method: 'GET',
      success: function success(data) {
        var apartments = []; // creo due array vuoti che saranno label e data del grafico

        var visitsCount = [];

        for (var key in data) {
          // popolo questi due array con i valori dell'oggetto data, i labels con la chiave e i data con il valore corrispondente
          apartments.push(key);
          visitsCount.push(data[key]);
        }

        createVisitsChart('#visits-chart', apartments, visitsCount); // Richiamo funzione di creazione grafico con id, label e data in ingresso
      },
      error: function error(err) {
        alert('errore API');
      }
    });
  }

  function createVisitsChart(id, labels, data) {
    // Funzione che crea un grafico tipo bar dato un id di destinazione e due array labels e data
    var ctx = $(id);
    var chart = new Chart(ctx, {
      type: 'bar',
      data: {
        datasets: [{
          label: 'Analisi Visite',
          backgroundColor: 'lightgreen',
          data: data
        }],
        labels: labels
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              // Definisco l'asse delle Y con punto iniziale e dimensione degli step
              beginAtZero: true,
              stepSize: 10
            }
          }]
        }
      }
    });
  }

  ;
});

/***/ }),

/***/ 1:
/*!******************************************!*\
  !*** multi ./resources/js/admin/show.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Applications/MAMP/htdocs/boolean/progetto_finale/BoolBnb/resources/js/admin/show.js */"./resources/js/admin/show.js");


/***/ })

/******/ });