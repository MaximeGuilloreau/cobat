'use strict';

angular.module('cobat').component('userWeek', {
  require: {
  },
  bindings: {
    week: '='
  },
  controller: function($scope, $ionicModal) {
    var ctrl = this;
    ctrl.days = this.week.map(function (day) {
      return day.getDay();
    });

    $ionicModal.fromTemplateUrl('templates/sites/modal-edit-week.html', {
      scope: $scope,
      animation: 'slide-in-up'
    }).then(function(modal) {
      console.log('my modal', modal);
      $scope.modal = modal;
    });
    $scope.openModal = function() {
      console.log('openModal');
      $scope.modal.show();
    };
    $scope.closeModal = function() {
      $scope.modal.hide();
    };
    // Cleanup the modal when we're done with it!
    $scope.$on('$destroy', function() {
      $scope.modal.remove();
    });
    // Execute action on hide modal
    $scope.$on('modal.hidden', function() {
      // Execute action
    });
    // Execute action on remove modal
    $scope.$on('modal.removed', function() {
      // Execute action
    });
  },
  templateUrl: 'templates/directives/user-week.html'
});
