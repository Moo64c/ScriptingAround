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
        redirectTo: '/live/1'
      })
      .when('/live', {
        redirectTo: '/live/1'
      })
      .when('/live/:pageNumber', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .when('/search', {
        redirectTo: '/search/ישראל/1'
      })
      .when('/search:searchString', {
        redirectTo: '/search/:searchString/1'
      })
      .when('/search/:searchString/:pageNumber', {
        templateUrl: 'views/search.html',
        controller: 'SearchCtrl'
      })
      .otherwise({
        redirectTo: '/live/1'
      });
  });
