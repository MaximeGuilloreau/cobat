'use strict';

angular.module('cobat').config(function ($stateProvider) {
  $stateProvider
  .state('login', {
    url: '/login',
    templateUrl: 'templates/login.html',
    controller: 'LoginCtrl'
  });
}).run(function ($rootScope, $log, SecurityService) {
  $rootScope.$on('$stateChangeStart', function(event, toState) {
    $log.log('stateChange', toState, SecurityService.getConnectedUser());

	});
});
