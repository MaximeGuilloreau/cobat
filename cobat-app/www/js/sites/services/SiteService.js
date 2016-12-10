'use strict';

angular.module('cobat').factory('sitesService', function (Restangular, $q) {
  var api = {};

  api.findAll = function () {
    return Restangular.all('sites').getList();
  };

  api.findById = function (siteId) {
    return Restangular.one('sites', siteId).get();
  };

  api.save = function (site) {
    return $q.when(site);
  };

  return api;
});
