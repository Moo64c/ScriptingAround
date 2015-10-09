'use strict';

/**
 * @ngdoc service
 * @name clientApp.account
 * @description
 * # account
 * Service in the clientApp.
 */
angular.module('clientApp')
.service('searchRequest', function ($q, $http, $timeout, Config, $rootScope) {

  // A private cache key.
  var cache = {};

  /**
   * Return the promise with the events list, from cache or the server.
   *
   * @returns {*}
   */
  this.get = function(searchString, pageNumber) {
    return $q.when(getDataFromBackend(searchString, pageNumber));
  };

  /**
   * Return events array from the server.
   *
   * @returns {$q.promise}
   */
  function getDataFromBackend(searchString, pageNumber) {
    var deferred = $q.defer();
    var url = Config.backend + '/api/basic_search/' + searchString  + '?page=' + pageNumber;

    $http({
      method: 'GET',
      url: url,
      transformResponse: prepareResponse
    })
      .success(function(response) {
        deferred.resolve(response);
      })
      .error(function(data) {
        deferred.resolve(data);
      }
    );

    return deferred.promise;
  }

  /**
   * Prepare response; Convert ID to int.
   *
   * As we explicetly require ui-router to match an int, we must case the
   * entity ID to integer.
   *
   * @param list
   *
   * @returns {*}
   */
  function prepareResponse(data) {
    // Convert response serialized to an object.
    data = angular.fromJson(data);

    if (!data.data) {
      // A 401 response was sent.
      return;
    }

    return data;
  }

  $rootScope.$on('clearCache', function() {
    cache = {};
  });
});
