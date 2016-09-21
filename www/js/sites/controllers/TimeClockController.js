var TimeClockController = function ($scope, usersService) {
  $scope.users = [];
  $scope.times = {};
  usersService.findAll().then(function (users) {
    $scope.users = users;
  });

  $scope.save = function (times) {
    console.log('times', times);
  };
};

angular
.module('cobat').controller('TimeClockCtrl', TimeClockController);
