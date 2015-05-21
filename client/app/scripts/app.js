'use strict';

/**
 * @ngdoc overview
 * @name clientApp
 * @description
 * # clientApp
 *
 * Main module of the application.
 */
angular
  .module('clientApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'config',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'yaru22.angular-timeago'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .when('/update', {
        templateUrl: 'views/updating.html',
        controller: 'UpdateCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
