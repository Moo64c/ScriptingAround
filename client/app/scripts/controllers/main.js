'use strict';

/**
 * @ngdoc function
 * @name clientApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the clientApp
 */
angular.module('clientApp')
  .controller('MainCtrl', function ($scope, newsList, $route) {
    $scope.pageNumber = parseInt($route.current.params.pageNumber);

    newsList.get($scope.pageNumber).then(function(data) {
      $scope.list = data.data;
      if (data.next) {
        $scope.nextPage = data.next.href;
      }
      if (data.previous) {
        $scope.prevPage = data.previous.href;
      }
      $scope.count = data.count;
    });

    $scope.toggleAll = function(e) {
      angular.forEach($scope.list, function(value, key) {
        value.show = e;
      });
    };
  });
