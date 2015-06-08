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
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('OrderDetailCtrl', ['$location', '$scope', 'orderService', '$stateParams', 'Environment',
        function ($location, $scope, orderService, $stateParams, Environment) {
            $scope.media = Environment.settings.media;
            $scope.orderId = $stateParams.orderId;
            var handleSuccess = function (data, status) {
                $scope.orderDetails = data[0];
                console.log($scope.orderDetails);
            };
            orderService.getOrder($scope.orderId).success(handleSuccess);
        }]);
});