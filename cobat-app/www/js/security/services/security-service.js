'use strict';

var SecurityService = function (ContextService) {
  var api = {};
  var connectedUser;

  api.setConnectedUser = function (user) {
    connectedUser = user;
    return connectedUser;
  };

  api.getConnectedUser = function () {
    return connectedUser;
  };

  api.removeConnectedUser = function () {
    connectedUser = null;
  };

  api.logout = function () {
    ContextService.removeToken();
  };

  return api;
};

angular.module('cobat').factory('SecurityService', SecurityService);
