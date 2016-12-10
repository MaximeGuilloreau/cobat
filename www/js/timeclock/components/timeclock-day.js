'use strict';

angular.module('cobat').component('timeclockDay', {
  templateUrl: 'templates/timeclock/timeclock-day.html',
  controller: function () {
    var ctrl = this;
    var timeclock = {
      date: this.date,
      amountHour: 7,
      worker: '/api/workers/'+this.worker.id
    };
    ctrl.timeclock = timeclock;
    this.times.push(timeclock);
  },
  bindings: {
    date: '=',
    times: '=',
    worker: '='
  }
});
