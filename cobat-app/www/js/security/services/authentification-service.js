'use strict';

var AuthentificationService = function ($q, $log, Restangular, SecurityService, jwtHelper, ContextService) {
  var api = {};

  api.login = function (data) {
    $log.log('login information', data);
    if (!data.username || !data.password) {
      return $q.reject();
    }

    return Restangular.all('login')
      .post(data)
      .then(function (response) {
        console.log('result', response);
        var token = response.token;
        var payload = jwtHelper.decodeToken(token);
        var date = jwtHelper.getTokenExpirationDate(token);
        var bool = jwtHelper.isTokenExpired(token);
        ContextService.setToken(token);
        console.log('payload', payload, date, bool);
    });
  };

  api.logout = function () {
    SecurityService.removeConnectedUser();
  };
  return api;
};

angular.module('cobat').factory('AuthentificationService', AuthentificationService);
