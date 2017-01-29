'use strict'

var DashController = function ($scope, SecurityService, $state, ContextService, CalendarService){
    $scope.hasDefaultSite = ContextService.hasDefaultSite();

    $scope.goToTimeClock = function () {
        var siteId = ContextService.getDefaultSite();
        var now = new Date();
        var dates = CalendarService.getWeekDate(now);

        $state.go('sites.timeclock', {
            siteId: siteId,
            startDate: dates[0],
            endDate: dates[1]
        });
        console.log('date result', dates);
    };

    $scope.logout = function () {
        SecurityService.logout();
        $state.go('login');
    };
};

angular.module('cobat').controller('DashCtrl', DashController);
