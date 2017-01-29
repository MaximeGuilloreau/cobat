
var SitesListController = function ($scope, $state, sitesService, ContextService) {
  var now = new Date();
  var user = ContextService.getConnectedUser();
  console.log('user', user);
  $scope.month = now.getMonth();
  $scope.year = now.getFullYear();
  var queryParams = {
    userId: user.id
  };
  sitesService.findAll(queryParams).then(function (sites) {
    $scope.sites = sites;
  });
};

angular.module('cobat').controller('ListSitesCtrl', SitesListController);
