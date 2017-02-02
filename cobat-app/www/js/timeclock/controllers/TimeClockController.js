'use strict';

var normalizeTimes = function (report, siteId) {
  var siteUri = '/api/sites/'+siteId,
    times = [],
    timeReport, userReport;

  for (var i = 0, l = report.length; i < l; i++) {
    userReport = report[i];
    for (var key in userReport.times) {
      timeReport = userReport.times[key];
      times.push({
        site: siteUri,
        worker: userReport.worker['@id'],
        date: timeReport.day,
        amountHour: timeReport.time.amountHour,
        '@id': !!timeReport.time['@id'] ? timeReport.time['@id'] : null
      });
    }
  }
  return times;
};

var TimeClockController = function (
  $scope,
  $stateParams,
  workersService,
  timeclockService,
  sitesService,
  CalendarService,
  ContextService
  ) {
  var siteId = $stateParams.siteId;
  $scope.title =
  $scope.workers = [];
  $scope.times = [];
  $scope.startDate = new Date($stateParams.startDate);
  $scope.endDate = new Date($stateParams.endDate);

  $scope.week = [];


  sitesService.findById(siteId).then(function (site) {
    $scope.site = site;
    
    ContextService.setDefaultSite(site.id);
  });

  $scope.week = CalendarService.buildRangeDays($scope.startDate, $scope.endDate);

  // Load user times
  timeclockService.getWeek($stateParams.siteId, $stateParams.startDate, $stateParams.endDate)
  .then(function (week) {
    console.log('woker list', week);
    $scope.workers = week;
    console.log($scope.workers);
  });

  // save all times
  $scope.save = function (report) {
    var times = normalizeTimes(report, siteId);
    timeclockService.saveAll(times).then(function (result) {
      // TODO: HANDLE NOTIFICATION
    });
  };
};

angular
.module('cobat').controller('TimeClockCtrl', TimeClockController);
