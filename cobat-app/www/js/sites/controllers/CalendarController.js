/* global angular */
'use strict';

var CalendarController = function (
  $log,
  $scope,
  $stateParams,
  $state,
  CalendarService
) {

  var month = parseInt($stateParams.month, 10);
  var year = parseInt($stateParams.year, 10);
  var date = new Date(year, month, 1);

  $scope.dates = [];
  $scope.i = 0;
  $scope.siteId = $stateParams.siteId;
  $scope.date = date;
  $scope.dates = CalendarService.buildWeekList(date);

  $scope.onSwipeLeft = function () {
    var newDate = angular.copy(date);
    newDate.setMonth(date.getMonth() + 1);
    $state.go('sites.calendar', {
      siteId: $scope.siteId,
      year: newDate.getFullYear(),
      month: newDate.getMonth()
    });
  };

  $scope.onSwipeRight = function () {
    var newDate = angular.copy(date);
    newDate.setMonth(date.getMonth() - 1);
    $state.go('sites.calendar', {
      siteId: $scope.siteId,
      year: newDate.getFullYear(),
      month: newDate.getMonth()
    });
  };
};

angular.module('cobat').controller('CalendarCtrl', CalendarController);
