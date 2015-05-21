'use strict';

/**
 * @ngdoc function
 * @name clientApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the clientApp
 */
angular.module('clientApp')
  .controller('UpdateCtrl', function ($scope, $location, updater) {
    updater.get().then(function(data) {
      $location.path('/');
    });
  });
