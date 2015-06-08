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
 * @description     Product config
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("products", {
                url: "/:locale/products/",
                templateUrl: '/app/NAD/Product/views/product.html',
                controller: 'ProductCtrl'
            })
            .state("productView", {
                url: "/:locale/product/view/:productId/",
                templateUrl: '/app/NAD/Product/views/product-detail.html',
                controller: 'ProductDetailCtrl'
            })
            .state("productCategories", {
                url: "/:locale/product/categories/",
                templateUrl: '/app/NAD/Product/views/category.html',
                controller: 'ProductCategoryCtrl'
            })
            .state("productCategoryView", {
                url: "/:locale/product/category/:categoryId/",
                templateUrl: '/app/NAD/Product/views/category-detail.html',
                controller: 'ProductCategoryDetailCtrl'
            });
    }]);
});