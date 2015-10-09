'use strict';

/**
 * @ngdoc function
 * @name clientApp.controller:SearchCtrl
 * @description
 * # SearchCtrl
 * Search controller of the clientApp
 */
angular.module('clientApp')
  .controller('SearchCtrl', function ($scope, searchRequest, $route) {
    $scope.pageNumber = parseInt($route.current.params.pageNumber);
    $scope.searchString = $route.current.params.searchString;

    searchRequest.get($scope.searchString, $scope.pageNumber).then(function(data) {

      if (!data) {
        $scope.error = "הבקשה נכשלה.";
        $scope.count = 0;
        return;
      }

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
