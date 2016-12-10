'use strict';

var LoginCtrl = function ($scope, $state, AuthentificationService) {

  $scope.login = function (data) {
    AuthentificationService.login(data).then(function (user) {
      $scope.user = user;
      console.log('isLog');
      $state.go('tab.dash');
    }).catch(function () {
      console.log('Logi error');
    });
  };
};

angular.module('cobat').controller('LoginCtrl', LoginCtrl);
