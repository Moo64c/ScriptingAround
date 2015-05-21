'use strict';

/**
 * @ngdoc service
 * @name clientApp.account
 * @description
 * # account
 * Service in the clientApp.
 */
angular.module('clientApp')
  .filter('dateObject', function($sce) {
    return function(val) {
      // Dates for Javascript are in milliseconds, while for PHP they are in seconds.
      val *= 1000;
      return new Date(parseInt(val));
    };
  });
