'use strict';

angular.module('cobat')
    .controller('ListUsersCtrl', function ($scope, usersService) {

    console.log('list users controller');
    usersService.findAll().then(function (users) {
        $scope.users = users;
    });

});
