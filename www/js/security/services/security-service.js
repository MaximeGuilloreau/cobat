'use strict';

var SecurityService = function () {
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

  return api;
};

angular.module('cobat').factory('SecurityService', SecurityService);
