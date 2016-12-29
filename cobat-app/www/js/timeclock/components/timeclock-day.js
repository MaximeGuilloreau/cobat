'use strict';
//TODO: put this in factory
var initTime = function (workerId, day) {
  return {
    date: day,
    worker: '/api/workers' + workerId,
    amountHour: 7,
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
