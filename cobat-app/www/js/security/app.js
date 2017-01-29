'use strict';

angular.module('cobat').config(function ($stateProvider) {
  $stateProvider
  .state('login', {
    url: '/login',
    templateUrl: 'templates/login.html',
    controller: 'LoginCtrl',
    data: {
      isSecured: false
    }
  });
}).config(function Config($httpProvider, jwtOptionsProvider) {
    jwtOptionsProvider.config({
      whiteListedDomains: ['localhost', 'vps357341.ovh.net']
    });
  }).config(function($httpProvider, jwtInterceptorProvider) {
		jwtInterceptorProvider.tokenGetter = /* @ngInject */ function(ContextService) {
			return ContextService.getToken();
		};
		$httpProvider.interceptors.push('jwtInterceptor');
	}).run(function ($rootScope, $state, ContextService) {
  $rootScope.$on('$stateChangeStart', function(event, toState) {
    var isSecured = true;
    var connectedUser = ContextService.getConnectedUser();
    if (toState.data && toState.data.isSecured !== undefined) {
      isSecured = toState.data.isSecured;
    }
		if (isSecured && !connectedUser) {
			event.preventDefault();
			$state.go('login');
		}
  });
});
