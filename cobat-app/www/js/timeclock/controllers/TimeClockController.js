'use strict';

var TimeClockController = function ($scope, $stateParams, workersService, timeclockService) {
  $scope.workers = [];
  $scope.times = [];
  $scope.startDate = new Date($stateParams.startDate);
  $scope.endDate = new Date($stateParams.endDate);

  $scope.week = [];

  var date = angular.copy($scope.startDate);

  while (date.getTime() !== $scope.endDate.getTime()) {
    $scope.week.push(angular.copy(date));
    date.setDate(date.getDate() + 1);
  }
  $scope.week.push(angular.copy(date));

  workersService.findAll().then(function (workers) {
    $scope.workers = workers;
  });

  $scope.save = function (times) {
    timeclockService.saveAll(times).then(function (result) {
      console.log('result', result);
    });
    console.log('times', times);
  };
};

angular
.module('cobat').controller('TimeClockCtrl', TimeClockController);
