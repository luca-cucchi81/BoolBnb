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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/guest/search.js":
/*!**************************************!*\
  !*** ./resources/js/guest/search.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  generateMap();
  clear();
  $('#filtra').click(function () {
    // Al click del bottone di invio filtri parte la funzione di ricerca
    search();
  });
  $('#clear').click(function () {
    // Al click del bottone di pulizia filtri prima resetto tutto e poi faccio una ricerca
    clear();
    search();
  });

  function clear() {
    // Funzione di pulizia che riporta tutti gli input ai valori di default
    $('#beds').val(1);
    $('#rooms').val(1);
    $('#radius').val(20);
    $('.check-filter').prop('checked', false);
  }

  ;

  function search() {
    var filters = filterscreate(); // Richiamo di funzione di creazione array filtri

    var rooms = parseInt($('#rooms').val()); // Prendo i valori degli input per letti e stanze

    var beds = parseInt($('#beds').val());
    $('.result').addClass('hidden'); // Nascondo tutti gli appartamenti

    $('.result').each(function () {
      // Per ogni appartamento
      var apartmentRooms = parseInt($(this).find('.rooms').text()); // Prendo i suoi valori di letti e stanze

      var apartmentBeds = parseInt($(this).find('.beds').text());
      var services = []; // Creo un array con i suoi servizi

      $(this).find('.service').each(function () {
        var service = $(this).data('service');
        services.push(service);
      });
      var check = isTrue(filters, services); // Richiamo funzione di intersezione tra due array

      if (rooms <= apartmentRooms && beds <= apartmentBeds && check) {
        // Se l'appartamento soddisfa tutti i criteri della ricerca lo visualizzo
        $(this).removeClass('hidden');
      }

      ;
    });
    $('#map').remove(); // Rimuovo e reinserisco la mappa per aggiornare tutti i markers

    $('#map-container').html('<div id="map"></div>');
    generateMap();
  }

  ;

  function generateMap() {
    // Solita funzione di generazione mappa con markerr, epicentro e controllo zoom
    (function () {
      var latlng = {
        lat: $('.coord-lat').val(),
        lng: $('.coord-lng').val()
      };
      var apartments = [];
      $('.result[class="result"]').each(function () {
        // Ciclo su ogni appartamento che sia visibile quindi con una sola classe
        var apartment = {}; // Popolazione oggetto con lat e lng per ogni appartamento

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
      var osmLayer = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 1,
        maxZoom: 19
      });
      var markers = [];

      for (var i = 0; i < apartments.length; i++) {
        var apartment = apartments[i];
        addApartmentToMap(apartment);
      }

      map.setView(new L.LatLng(latlng.lat, latlng.lng), 13);
      map.addLayer(osmLayer);

      function addApartmentToMap(apartment) {
        // Aggiungo tutti i markers alla Mappa
        var marker = L.marker({
          'lat': apartment.lat,
          'lng': apartment.lng
        });
        marker.addTo(map);
        markers.push(marker);
      }
    })();
  }

  ;

  function filterscreate() {
    // Funzione che crea un array filters inserendo i valori delle checkbox che sono stati cliccati dall'utente
    var filters = [];
    $('.check-filter').each(function () {
      if ($(this).prop('checked') == true) {
        filters.push(parseInt($(this).val()));
      }
    });
    return filters;
  }

  ;

  function isTrue(arr, arr2) {
    // Funzione che dati due array in ingresso controlla se il secondo array ha almeno un valore in comune con il primo array
    return arr.every(function (i) {
      return arr2.includes(i);
    }); // Restituisce un booleano
  }

  ;
});

/***/ }),

/***/ 4:
/*!********************************************!*\
  !*** multi ./resources/js/guest/search.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Applications/MAMP/htdocs/final-project/BoolBnb/resources/js/guest/search.js */"./resources/js/guest/search.js");


/***/ })

/******/ });