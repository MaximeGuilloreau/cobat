'use strict';

angular.module('cobat').
factory('usersService', function ($q, Restangular) {
  var api = {};

  api.findAll = function () {
    return $q.when([
      {
        id: 1,
        name: 'Users 1',
        firstName: 'firstName 1'
      }, {
        id: 2,
        name: 'Users 2',
        firstName: 'firstName 2'
      }, {
        id: 3,
        name: 'Users 1',
        firstName: 'firstName 1'
      }, {
        id: 4,
        name: 'Users 2',
        firstName: 'firstName 2'
      }, {
        id: 5,
        name: 'Users 1',
        firstName: 'firstName 1'
      }, {
        id: 6,
        name: 'Users 2',
        firstName: 'firstName 2'
      }
    ]);
  };

  api.getById = function () {
    return $q.when({
      id: 1,
      name: 'User 1',
      firstName: 'firstName'
    });
  };

  return api;
});
