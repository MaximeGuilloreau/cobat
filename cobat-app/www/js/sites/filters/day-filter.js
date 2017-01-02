'use strict';

angular.module('cobat').filter('day', function () {
  var fullDays = [
    'Lundi',
    'Mardi',
    'Mercredi',
    'Jeudi',
    'Vendredi',
    'Samedi',
    'Dimanche'
  ];

  var days = [
    'L',
    'M',
    'M',
    'J',
    'V',
    'S',
    'D'
  ];
  return function (input, full) {
    if (full) {
      return fullDays[input - 1];
    }
    return days[input - 1];
  };
});
