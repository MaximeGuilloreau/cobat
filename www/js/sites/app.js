'use strict';

angular.module('cobat').config(function ($stateProvider) {
  $stateProvider
    .state('sites', {
      url: '/sites',
      abstract: true,
      templateUrl: 'templates/tabs.html'
    })
  .state('sites.list', {
    url: '/list',
    views: {
      'tab-sites': {
        templateUrl: 'templates/tab-sites.html',
        controller: 'ListSitesCtrl'
      }
    }
  }).state('sites.new', {
    url: '/new',
    views: {
      'tab-sites': {
        templateUrl: 'templates/sites/edit-sites.html',
        controller: 'EditSitesCtrl'
      }
    }
  })
  .state('sites.edit', {
    url: '/edit/:siteId',
    views: {
      'tab-sites': {
        templateUrl: 'templates/sites/edit-sites.html',
        controller: 'EditSitesCtrl'
      }
    }
  })
  .state('sites.calendar', {
    url: '/calendar/:siteId/:month/:year',
    views: {
      'tab-sites': {
        templateUrl: 'templates/sites/calendar.html',
        controller: 'CalendarCtrl'
      }
    }
  }).state('sites.timeclock', {
    url: '/time-clock/:siteId/:startDate/:endDate',
    views: {
      'tab-sites': {
        templateUrl: 'templates/sites/time-clock.html',
        controller: 'TimeClockCtrl'
      }
    }
  });
});
