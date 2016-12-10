/* global angular */
'use strict';

var CalendarController = function ($log, $scope, $stateParams) {
  $scope.dates = [];
  $scope.i = 0;
  $scope.siteId = $stateParams.siteId;
  var month = parseInt($stateParams.month);
  var year = parseInt($stateParams.year);
  var date = new Date(year, month, 1);

  $scope.date = date;
  var day;
  var week = [];
  while (date.getMonth() === month) {
    day = date.getDay();
    if (day === 0) {
      $scope.dates.push(week);
      week = [];
    }

    week.push(angular.copy(date));
    date.setDate(date.getDate() + 1);
  }

  $scope.dates.push(week);
};

angular.module('cobat').controller('CalendarCtrl', CalendarController);
