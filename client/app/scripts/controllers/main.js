'use strict';

/**
 * @ngdoc function
 * @name clientApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the clientApp
 */
angular.module('clientApp')
  .controller('MainCtrl', function ($scope, newsList) {
    newsList.get().then(function(list) {
      $scope.list = list;
    });

    $scope.toggleAll = function(e) {
      angular.forEach($scope.list, function(value, key) {
        value.show = e;
      });
    };
  });
