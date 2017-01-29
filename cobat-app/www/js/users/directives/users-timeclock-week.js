'use strict';

var formatWeek = function (week) {
  var result = {};
  for(var i = 0, l = week.length; i < l; i++) {
    var day = week[i];
    result[(new Date(day)).toDateString()] = {
      day: day,
      time: {}
    };
  }

  return result;
};

angular.module('cobat').component('usersTimeclockWeek', {
  templateUrl: 'templates/users/users-timeclock-week.html',
  controller: function () {
    var ctrl = this;
    var weekReport = formatWeek(ctrl.week);
    for(var i = 0, l = ctrl.worker.times.length; i < l; i++) {
      var time = ctrl.worker.times[i];
      weekReport[(new Date(time.date)).toDateString()].time = time;
    }

    ctrl.times.push({
      worker: ctrl.worker,
      times: weekReport
    });

    ctrl.weekReport = weekReport;
  },
  bindings: {
    worker: '=',
    week: '=',
    times: '='
  }
});
