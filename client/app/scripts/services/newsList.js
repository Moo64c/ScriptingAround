'use strict';

/**
 * @ngdoc service
 * @name clientApp.account
 * @description
 * # account
 * Service in the clientApp.
 */
angular.module('clientApp')
.service('newsList', function ($q, $http, $timeout, Config, $rootScope) {

  // A private cache key.
  var cache = {};

  // Update event broadcast name.
  var broadcastUpdateEventName = 'RotternewsNewsList';

  /**
   * Return the promise with the events list, from cache or the server.
   *
   * @returns {*}
   */
  this.get = function(pageNumber) {
    return $q.when(getDataFromBackend(pageNumber));
  };

  /**
   * Return events array from the server.
   *
   * @returns {$q.promise}
   */
  function getDataFromBackend(pageNumber) {
    var deferred = $q.defer();
    var url = Config.backend + '/api/v1.1/news_item?page=' + pageNumber;

    $http({
      method: 'GET',
      url: url,
      transformResponse: prepareResponse
    }).success(function(response) {
      deferred.resolve(response);
    });

    return deferred.promise;
  }

  /**
   * Save meters in cache, and broadcast en event to inform that the meters data changed.
   *
   * @param itemId
   *   The item ID.
   * @param data
   *   The data to cache.
   */
  var setCache = function(data) {
    // Cache data.
    cache = {
      data: data,
      timestamp: new Date()
    };

    // Clear cache in 60 seconds.
    $timeout(function() {
      cache = {};
    }, 60000);

    // Broadcast a change event.
    $rootScope.$broadcast(broadcastUpdateEventName);
  };

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
