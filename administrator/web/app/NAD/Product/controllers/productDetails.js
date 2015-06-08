'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADProduct
 * @description     ProductDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('ProductDetailsCtrl', function ($controller, $scope, resourceService) {

        $scope.route = {
            name: 'Product',
            collection: 'product',
            edit: 'productEdit'
        };

        var itemService = new resourceService('product');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});