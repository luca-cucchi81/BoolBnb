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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin/home.js":
/*!************************************!*\
  !*** ./resources/js/admin/home.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

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
      success: function success(data) {
        var apartments = [];
        var sponsorshipsCount = [];

        for (var key in data) {
          apartments.push(key);
          sponsorshipsCount.push(data[key]);
        }

        createSponsorshipsChart('#sponsorships-chart', apartments, sponsorshipsCount);
      },
      error: function error(err) {
        alert('errore API');
      }
    });
  }

  ;

  function apiCallMessagesChart() {
    $.ajax({
      url: messagesUrl,
      method: 'GET',
      success: function success(data) {
        var apartments = [];
        var messagesCount = [];

        for (var key in data) {
          apartments.push(key);
          messagesCount.push(data[key]);
        }

        createMessagesChart('#messages-chart', apartments, messagesCount);
      },
      error: function error(err) {
        alert('errore API');
      }
    });
  }

  ;

  function apiCallVisitsChart() {
    $.ajax({
      url: visitsUrl,
      method: 'GET',
      success: function success(data) {
        var apartments = [];
        var visitsCount = [];

        for (var key in data) {
          apartments.push(key);
          visitsCount.push(data[key]);
        }

        createVisitsChart('#visits-chart', apartments, visitsCount);
      },
      error: function error(err) {
        alert('errore API');
      }
    });
  }

  function createMessagesChart(id, labels, data) {
    // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
    var ctx = $(id);
    var chart = new Chart(ctx, {
      type: 'bar',
      data: {
        datasets: [{
          label: 'Tot. Messages',
          backgroundColor: '#ff6666',
          data: data
        }],
        labels: labels
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
  }

  ;

  function createSponsorshipsChart(id, labels, data) {
    // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
    var ctx = $(id);
    var chart = new Chart(ctx, {
      type: 'bar',
      data: {
        datasets: [{
          label: 'Tot. Spent',
          backgroundColor: 'lightgreen',
          data: data
        }],
        labels: labels
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
  }

  ;

  function createVisitsChart(id, labels, data) {
    // Funzione che crea un grafico tipo line dato un id di destinazione e due array labels e data
    var ctx = $(id);
    var chart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
          data: data,
          backgroundColor: ['lightblue', 'lightgreen', 'yellow', 'pink']
        }],
        labels: labels
      },
      options: {
        responsive: true
      }
    });
  }

  ;
});

/***/ }),

/***/ 3:
/*!******************************************!*\
  !*** multi ./resources/js/admin/home.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Applications/MAMP/htdocs/final-project/BoolBnb/resources/js/admin/home.js */"./resources/js/admin/home.js");


/***/ })

/******/ });