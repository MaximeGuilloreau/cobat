/* global angular */
'use strict';

var CalendarController = function ($log, $scope, $stateParams, sitesService) {
  $scope.dates = [];

  var siteId = $stateParams.siteId;
  var month = parseInt($stateParams.month);
  var year = parseInt($stateParams.year);
  var date = new Date(year, month, 1);

  while (date.getMonth() === month) {
    console.log('test date', date);
    $scope.dates.push(angular.copy(date));
    date.setDate(date.getDate() + 1);
  }
};

angular.module('cobat').controller('CalendarCtrl', CalendarController);
