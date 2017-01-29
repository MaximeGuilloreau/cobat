'use strict';

angular.module('cobat').factory('workersService', function ($q, Restangular) {
  var api = {};

  api.findAll = function(query, noPaginate) {
    if (!!noPaginate) {
      return Restangular
              .all('workers')
              .getList()
              .then(function (workers) {
                var metadata = workers.metadata;
                var nbPages = (Math.trunc(metadata['hydra:totalItems'] / metadata['hydra:itemsPerPage'])) + 1 ; 
                console.log('nbPages', nbPages);
                console.log('workers', workers, workers.metadata);
                var workersPromises = [
                  $q.when(workers)
                ];
                for (var i = 2; i <= nbPages; i++) {
                  console.log('call page ', nbPages);
                  workersPromises.push(api.findAll({page: i}));
                }

                return $q.all(workersPromises);
              }).then(function (results) {
                console.log('results', results);
                return results.reduce(function ( workersResult ,workers) {
                  return workersResult.concat(workers);
                }, []);
              });  
    }

    return Restangular.all('workers').getList(query);
  };

  api.getById = function () {
    return Restangular.one('workers').get();
  };

  return api;
});
