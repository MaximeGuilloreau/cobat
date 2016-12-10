'use strict';

angular.module('cobat').component('timeclockHeader', {
  templateUrl: 'templates/timeclock/timeclock-header.html',
  controller: function () {
    var ctrl = this;
  },
  bindings: {
    week: "="
  }
});
