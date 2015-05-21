'use strict';

/**
 * @ngdoc service
 * @name clientApp.account
 * @description
 * # account
 * Service in the clientApp.
 */
angular.module('clientApp')
  .filter('unsafe', function($sce) {
    return function(val) {
      return $sce.trustAsHtml(val);
    };
  });
