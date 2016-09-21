'use strict';

var LoginCtrl = function ($scope, $state, AuthentificationService) {

  $scope.login = function (data) {
    AuthentificationService.login(data).then(function (user) {
      $scope.user = user;
      $state.go('tab.dash');
    });
  };
};

angular.module('cobat').controller('LoginCtrl', LoginCtrl);
