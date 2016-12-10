'use strict';

var AuthentificationService = function ($q, $log, SecurityService) {
  var api = {};

  api.login = function (data) {
    $log.log('login information', data);
    if (!data.username || !data.password) {
      return $q.reject();
    }

    if (data.username !== data.password) {
      return $q.reject();
    }

    var user = {
      name: 'admin',
      firstName: 'admin'
    };

    return $q.when(SecurityService.setConnectedUser(user));
  };

  api.logout = function () {
    SecurityService.removeConnectedUser();
  };
  return api;
};

angular.module('cobat').factory('AuthentificationService', AuthentificationService);
