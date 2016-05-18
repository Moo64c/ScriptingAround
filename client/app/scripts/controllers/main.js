'use strict';

/**
 * @ngdoc function
 * @name clientApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the clientApp
 */
angular.module('clientApp')
  .controller('MainCtrl', function ($scope, newsList, $route, hotkeys, $location, $document) {
    $scope.pageNumber = parseInt($route.current.params.pageNumber);
    $scope.currentItem = -1;

    newsList.get($scope.pageNumber).then(function(data) {

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

    $scope.goTo = function(direction) {
      var value = (direction + "") == "next" ? 1 : -1;
      if (value == 1 || $scope.pageNumber > 1) {
        $location.path('/live/' + ($scope.pageNumber + value));
      }
    };

    $scope.anchor = function(anchor) {
      var object = $document.find("#item" + anchor);

      $document.find('body').animate({scrollTop: object.offset().top}, "slow");
    };

    // Add some hot keys.
    hotkeys.add({
        combo: 'w',
        description: 'Open previous item',
        callback: function() {
          if ($scope.currentItem > -1) {
            $scope.currentItem--;

            setTimeout(function() {$scope.anchor($scope.currentItem)}, 1000);
          }
        }
      });
    hotkeys.add({
        combo: 's',
        description: 'Open next item',
        callback: function() {
          if ($scope.currentItem < $scope.list.length) {
            $scope.currentItem++;
            setTimeout(function() {$scope.anchor($scope.currentItem)}, 402);
          }
          else {
            // Next page.
            $scope.goTo("next");
          }
        }
      });
    hotkeys.add({
      combo: 'a',
      description: 'Previous page',
      callback: function() {
        $scope.goTo("previous");
      }
    });
    hotkeys.add({
      combo: 'd',
      description: 'Next page',
      callback: function() {
        $scope.goTo("next");
      }
    });

    $scope.hotkeys = hotkeys;
  });
