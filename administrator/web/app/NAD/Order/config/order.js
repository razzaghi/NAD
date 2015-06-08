'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADOrder
 * @description     Module configuration
 */

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("orders", {
                    url: "/:locale/orders/",
                    templateUrl: '/app/NAD/Kernel/views/collection.html',
                    controller: 'OrderCtrl'
                })
                .state("orderEdit", {
                    url: "/:locale/order/edit/:id/",
                    templateUrl: '/app/NAD/Order/views/edit.html',
                    controller: 'OrderDetailsCtrl'
                })
        }])
        .run(['$rootScope', 'Environment', function ($rootScope, Environment) {
            $rootScope.topMenu.push(
                {
                    "ordering": 400,
                    "slug": '/orders/',
                    "title": 'Orders'
                }
            );
        }]);
});