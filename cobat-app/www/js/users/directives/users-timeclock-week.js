'use strict';

angular.module('cobat').component('usersTimeclockWeek', {
  templateUrl: 'templates/users/users-timeclock-week.html',
  controller: function () {
    var ctrl = this;
  },
  bindings: {
    worker: '=',
    week: '=',
    times: '='
  }
});
