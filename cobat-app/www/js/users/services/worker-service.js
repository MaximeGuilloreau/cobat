'use strict';

angular.module('cobat').factory('workersService', function (Restangular) {
  var api = {};

  api.findAll = function() {
    return Restangular.all('workers').getList();
  };

  api.getById = function () {
    return Restangular.one('workers').get();
  };

  return api;
});
