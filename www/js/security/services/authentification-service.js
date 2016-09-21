'use strict';

var AuthentificationService = function ($q, $log, SecurityService) {
  var api = {};

  api.login = function (data) {
    $log.log('login information', data);
    return $q.when({
      id: 1,
      name: 'name',
      firstName: 'firstName'
    });
  };

  api.logout = function () {
    SecurityService.removeConnectedUser();
  };
  return api;
};

angular.module('cobat').factory('AuthentificationService', AuthentificationService);
