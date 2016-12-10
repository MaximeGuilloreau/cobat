'use strict';

	// from https://github.com/dunglas/DunglasJsonLdApiBundle
angular.module('cobat').config(function(RestangularProvider) {
  RestangularProvider.setBaseUrl('http://localhost:8000/api');
    // JSON-LD @id support
		RestangularProvider.setRestangularFields({
			id: '@id'
		});
		RestangularProvider.setSelfLinkAbsoluteUrl(false);

		// Hydra collections support
		RestangularProvider.addResponseInterceptor(function(data, operation) {
			// Remove trailing slash to make Restangular working
			var populateHref = function(data) {
				if (data['@id']) {
					data.href = data['@id'].substring(1);
					// TODO very dirty !!! we need a better way to handle entity ID
					data.id = data['@id'].substring(data['@id'].lastIndexOf('/') + 1);
				}
			};

			// Populate href property for the collection
			populateHref(data);

			if ('getList' === operation) {
				var jsonMode = !!data['hydra:member'] ? 'hydra:member' : 'data';
				var collectionResponse = data[jsonMode];
				collectionResponse.metadata = {};

				// Put metadata in a property of the collection
				angular.forEach(data, function(value, key) {
					if (jsonMode !== key) {
						collectionResponse.metadata[key] = value;
					}
				});

				// Populate href property for all elements of the collection
				angular.forEach(collectionResponse, populateHref);

				return collectionResponse;
			}

			return data;
		});
	});
