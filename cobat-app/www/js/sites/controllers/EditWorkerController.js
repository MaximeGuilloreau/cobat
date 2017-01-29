'user strict';

var EditWorkerCtrl = function ($stateParams, $scope,sitesService, workersService, $q) {
    var siteId = $stateParams.siteId;
    
    $q.all([
        sitesService.findById(siteId),
        workersService.findAll({}, true)  
    ]).then(function (result) {
        $scope.site = result[0];
        siteWorkers = $scope.site.workers;
        var workers = result[1];
        workers = workers.map(function (worker) {
            if (-1 !== siteWorkers.indexOf(worker['@id'])) {
                worker.isSelected = true;
            }
            return workers;
        });
        $scope.workers = result[1];
    });

    $scope.updateWorkers = function (workers) {
        console.log('save worker', workers);
        var selectWorker = workers.filter(function (worker) {
            return worker.isSelected;
        }).map(function (worker) {
            return worker['@id'];
        });
        $scope.site.workers = selectWorker;
        sitesService.save($scope.site);
    };


};

angular.module('cobat').controller('EditWorkerCtrl', EditWorkerCtrl);