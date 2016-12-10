'use strict';

angular.module('cobat').component('weekCalendar', {
  templateUrl: 'templates/directives/week-calendar.html',
  controller: function ($scope, $filter) {
    var ctrl = this;
    ctrl.startDate = this.week[0];
    ctrl.endDate = this.week[this.week.length-1];
    ctrl.startDateparam = $filter('date')(ctrl.startDate, 'yyyy-MM-dd');
    ctrl.endDateparam = $filter('date')(ctrl.endDate, 'yyyy-MM-dd');
  },
  bindings: {
    week: '=',
    siteId: '='
  }
});
