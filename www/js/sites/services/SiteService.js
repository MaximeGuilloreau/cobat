'use strict';

angular.module('cobat').factory('sitesService', function ($q) {
    var api = {};

    api.findAll = function () {
        return $q.when([
            {
                name: "Site 1"
            } , {
                name: "Site 2"
            }
        ]);
    };

    api.save = function (site) {
      return $q.when(site);
    };

    return api;
});
