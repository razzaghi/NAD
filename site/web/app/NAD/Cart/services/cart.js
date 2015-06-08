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
    app.service('cartService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                getCartItems: function ($scope) {
                    var url = Environment.settings.api + '/cart/';
                    console.log(url);
                    return $http.get(url);
                },
                addToCart: function ($scope) {
                    var qty = 1;
                    var productId = $scope.productDetails.product.id;
                    var url = Environment.settings.api + '/cart/product/' + productId + '/qty/' + qty + '/add.json';
                    console.log(url);
                    return $http.post(url);
                },
                updateInCart: function (item) {
                    var qty = item.qty;
                    var productId = item.product.id;
                    var url = Environment.settings.api + '/cart/product/' + productId + '/qty/' + qty + '/update.json';
                    console.log(url);
                    return $http.put(url);
                },
                getTotalFromCart: function (cartItems) {
                    var total = -1;
                    angular.forEach(cartItems, function (item) {
                        total += item.qty * item.product.price;
                    });
                    return total;
                }
            };
        }]);
});