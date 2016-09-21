var SiteEditController = function ($log, $scope, sitesService) {
  $scope.saveSite = function () {
    sitesService.save.then(function (site) {
      $log.log('savesite', site);
    });
  };
};
angular.module('cobat').controller('EditSitesCtrl', SiteEditController);
