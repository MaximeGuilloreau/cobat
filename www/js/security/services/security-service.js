'use strict';

var SecurityService = function () {
  var api = {};
  var connectedUser;

  api.getConnectedUser = function () {
    connectedUser = {
      name: 'connectedUser',
      firstName: 'admin'
    };
    return connectedUser;
  };

  api.removeConnectedUser = function () {
    connectedUser = null;
  };

  return api;
};

angular.module('cobat').factory('SecurityService', SecurityService);
