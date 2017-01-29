'use strict';

var ContextService = function (store, jwtHelper) {
  var api = {};

  api.setToken = function (token) {
    store.set('token', token);
  };

  api.getToken = function () {
    return store.get('token');
  };

  api.getConnectedUser = function () {
    var token = store.get('token');
    if (token) {
      return jwtHelper.decodeToken(token);
    }
    return null;
  };

  api.removeToken = function () {
    store.remove('token', token);
  };

  return api;
};

angular.module('cobat').factory('ContextService', ContextService);
