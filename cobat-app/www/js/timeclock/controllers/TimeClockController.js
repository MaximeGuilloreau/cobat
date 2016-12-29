'use strict';

var normalizeTimes = function (report, siteId) {
  var siteUri = '/api/sites/'+siteId,
  times = [],
  timeReport, userReport;

  for (var i = 0, l = report.length; i < l; i++) {
    userReport = report[i];
    for(var key in userReport.times) {
      timeReport = userReport.times[key];
      times.push({
          site: siteUri,
          worker: userReport.worker['@id'],
          date: timeReport.day,
          amountHour: timeReport.time.amountHour,
          id: !!timeReport.time['@id'] ? timeReport.time['@id'] : null
        });
    }
  }
  return times;
};

var TimeClockController = function ($scope, $stateParams, workersService, timeclockService) {
  var siteId = $stateParams.siteId;

  $scope.workers = [];
  $scope.times = [];
  $scope.startDate = new Date($stateParams.startDate);
  $scope.endDate = new Date($stateParams.endDate);

  $scope.week = [];

  // TODO: put this in function
  // build load calendar
  var date = angular.copy($scope.startDate);

  while (date.getTime() !== $scope.endDate.getTime()) {
    $scope.week.push(angular.copy(date));
    date.setDate(date.getDate() + 1);
  }

  $scope.week.push(angular.copy(date));

  // Load user times
  timeclockService.getWeek($stateParams.siteId, $stateParams.startDate, $stateParams.endDate).then(function (week) {
    $scope.workers = week;
    console.log('week', week);
  });

  // save all times
  $scope.save = function (report) {

    var times = normalizeTimes(report, siteId);
    console.log('times to save', times);

    timeclockService.saveAll(times).then(function (result) {
      console.log('result', result);
    });
  };
};

angular
.module('cobat').controller('TimeClockCtrl', TimeClockController);
