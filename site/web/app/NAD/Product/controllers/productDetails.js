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
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('ProductDetailCtrl', ['$scope', '$location', '$stateParams', 'productService', '$rootScope', 'cartService', 'notify', 'Environment', 'authService',
        function ($scope, $location, $stateParams, productService, $rootScope, cartService, notify, Environment, authService) {
            $scope.media = Environment.settings.media;
            $scope.isDisabled = true;

            var productURL = $stateParams.productId;
            var handleSuccess = function (data, status) {
                $scope.productDetails = data;
                $rootScope.productTitle = $scope.title;

                if ($scope.product) {
                    $scope.isDisabled = false;
                }
                window.disqus_shortname = $rootScope.disqusShortname;
                $scope.showComments = false;
            };
            productService.getProductByURL(productURL).success(handleSuccess);

            // Add product to cart
            $scope.addToCart = function () {

                // if user is guest - redirect or login page
                if (typeof $rootScope.user === 'undefined') {
                    authService.authenticateWithModal();
                } else {
                    $scope.isDisabled = true;
                    cartService.addToCart($scope).success(
                        function (data, status) {
                            notify(data.message);
                            $scope.isDisabled = false;
                        }
                    ).error(function (data, status) {
                            notify(data.message);
                            $scope.isDisabled = false;
                        });
                }
            };

        }]);
});