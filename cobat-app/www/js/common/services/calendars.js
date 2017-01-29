'use strict';

var CalendarService = function () {
  var api = {};

/**
 * Build week list by months
 * @param  {Date} date
 * @return {Array} array of week
 */
  api.buildWeekList = function (date) {
    var dateIterator = angular.copy(date);
    var day;
    var week = [];
    var dates = [];
    var month = dateIterator.getMonth();
    while (dateIterator.getMonth() === month) {
      day = dateIterator.getDay();
      // finish week at sunday
      if (day === 1 && week.length > 0) {
        dates.push(week);
        week = [];
      }

      week.push(angular.copy(dateIterator));
      dateIterator.setDate(dateIterator.getDate() + 1);
    }

    dates.push(week);

    return dates;
  };

  api.buildRangeDays = function (startDate, endDate) {
    // build load calendar
    var date = angular.copy(startDate);
    var week = [];

    while (date.getTime() !== endDate.getTime()) {
      week.push(angular.copy(date));
      date.setDate(date.getDate() + 1);
    }

    return week;
  };

  var getEndWeek = function (date) {
    var day  = date.getDay();
    var endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    endDate.setDate(date.getDate() + ( 7 - day));
    return endDate;
  };
  
  var getStartWeek = function (date) {
    var day = date.getDay();

    var startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    startDate.setDate(date.getDate()  - (day - 1));

    return startDate;
  };

  api.getWeekDate = function (date) {
    return [
      getStartWeek(date),
      getEndWeek(date)
    ];
  };

  return api;
};

angular.module('cobat').factory('CalendarService', CalendarService);
