'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADPage
 * @description     PageDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('PageDetailsCtrl', function ($controller, $scope, resourceService) {

        $scope.route = {
            name: 'Page',
            collection: 'pages',
            edit: 'pageEdit'
        };

        var itemService = new resourceService('page');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});