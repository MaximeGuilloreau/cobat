'use strict';

angular.module('cobat')
.config(function ($stateProvider) {

    $stateProvider
      .state('users', {
          url: '/users',
          abstract: true,
          templateUrl: 'templates/tabs.html'
      })
    .state('users.list', {
        url: '/list',
        views: {
            'tab-users' :{
                templateUrl: 'templates/tab-users.html',
                controller: 'ListUsersCtrl'
            }
        }
    }).state('users.new', {
        url: '/new',
        views: {
            'tab-users' :{
                templateUrl: 'templates/users/tab-edit-users.html',
                controller: 'EditUsersCtrl'
            }
        }
    });
});
