
var SitesListController = function ($scope, sitesService) {
  var now = new Date();
  $scope.month = now.getMonth();
  $scope.year = now.getFullYear();

  sitesService.findAll().then(function (sites) {
    $scope.sites = sites;
  });
};

angular.module('cobat').controller('ListSitesCtrl', SitesListController);
