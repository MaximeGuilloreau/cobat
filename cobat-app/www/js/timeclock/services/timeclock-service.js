'use strict';

angular.module('cobat').factory('timeclockService', function ($q, Restangular) {
  var api = {};

  api.findBy = function () {

  };

  api.saveAll = function (timeclocks) {
    return Restangular.all('times/mass-save').post(timeclocks);
  };

  api.getWeek = function (siteId, dateStart, dateEnd) {
    return Restangular.all('times/week/'+siteId+'/'+dateStart+'/'+dateEnd).getList();
  };

  api.save = function (timeclock) {
    if (timeclock.id) {
      return Restangular.one('times', timeclock.id).put(timeclock);
    }

    return Restangular.all('times').post(timeclock);
  };

  return api;
});
