'use strict';

var ContextService = function (store, jwtHelper) {
  var api = {};

  var defaultSite = null;
  var connectedUser = null;

  api.getDefaultSite = function (site) {
    return !!defaultSite ? defaultSite : store.get('defaultSite', site);
  };

  api.setDefaultSite = function (siteId) {
    store.set('defaultSite', siteId);
  };

  api.hasDefaultSite = function () {
    return !!api.getDefaultSite();
  }

  api.setToken = function (token) {
    store.set('token', token);
  };

  api.getToken = function () {
    return store.get('token');
  };

  api.getConnectedUser = function () {

    if (api.isTokenExpired()) {
      connectedUser = null;
      api.removeToken();
    }

    if (!!connectedUser) {
      return connectedUser;
    }

    var token = store.get('token');
    if (token) {
      return jwtHelper.decodeToken(token);
    }
    return null;
  };

  api.removeToken = function () {
    store.remove('token'  );
  };

  api.isTokenExpired = function() {
    var token = api.getToken();
    return jwtHelper.isTokenExpired(token);
  };

  return api;
};

angular.module('cobat').factory('ContextService', ContextService);
