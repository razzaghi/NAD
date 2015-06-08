'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADAddressing
 * @description     AddressingCountryDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('AddressingCountryDetailsCtrl', function ($controller, $scope, resourceService) {

        $scope.route = {
            name: 'Country',
            collection: 'countries',
            edit: 'countryEdit'
        };

        var itemService = new resourceService('addressing/country');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});