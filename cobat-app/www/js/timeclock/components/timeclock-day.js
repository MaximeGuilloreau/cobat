'use strict';

var getDefaultHour = function (date) {
  var defaultHourAmout = [0, 8, 8, 8, 8, 8, 7];
  var day = date.getDay();

  return defaultHourAmout[day];
};

var initTime = function (workerId, day) {
  return {
    date: day,
    worker: '/api/workers' + workerId,
    amountHour: getDefaultHour(day),
  };
};

angular.module('cobat').component('timeclockDay', {
  templateUrl: 'templates/timeclock/timeclock-day.html',
  controller: function () {
    var ctrl = this;
    if(angular.equals(ctrl.date.time, {})) {
      ctrl.date.time = initTime(ctrl.worker.id, ctrl.date.day);
    }
  },
  bindings: {
    date: '=',
    times: '=',
    worker: '='
  }
});
