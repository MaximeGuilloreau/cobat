'use strict';

var extractIriFilter = function (input) {
  return input.substring(input.lastIndexOf('/') + 1);
};

angular.module('cobat').filter('extract-iri', extractIriFilter);
