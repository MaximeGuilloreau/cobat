'use strict';

angular.module('cobat').factory('sitesService', function (Restangular, $q) {
  var api = {};

  api.findAll = function (query) {

    var queryParams = {};
    console.log('query', query);
    if (!!query && !!query.userId) {
      queryParams.user = query.userId;
    }

    return Restangular.all('sites').getList(queryParams);
  };

  api.findById = function (siteId) {
    return Restangular.one('sites', siteId).get();
  };

  api.save = function (site) {
    return $q.when(site);
  };

  return api;
});
