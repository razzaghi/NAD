'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADCart
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('CartCtrl', ['$location', '$scope', 'cartService', 'notify', 'Environment',
        function ($location, $scope, cartService, notify, Environment) {

            $scope.media = Environment.settings.media;

            $scope.total = function () {
                return cartService.getTotalFromCart($scope.cartItems);
            };

            $scope.getCartItems = function () {
                cartService.getCartItems($scope).success(function (data, status) {
                        $scope.cartItems = data;
                    }
                ).error(function (data, status) {
                    });
            };
            $scope.getCartItems();

            // Update product qty
            $scope.updateProductQty = function (item) {
                cartService.updateInCart(item).success(
                    function (data, status) {
                        notify(data.message);
                        $scope.isDisabled = false;
                        $scope.getCartItems();
                    }
                ).error(function (data, status) {
                        notify(data.message);
                        $scope.isDisabled = false;
                    });
            }
        }
    ]);
});