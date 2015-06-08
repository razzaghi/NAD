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
 * @description     Module configuration
 */

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("products", {
                    url: "/:locale/products/",
                    templateUrl: '/app/NAD/Kernel/views/collection.html',
                    controller: 'ProductCtrl'
                })
                .state("productEdit", {
                    url: "/:locale/product/edit/:id/",
                    templateUrl: '/app/NAD/Product/views/edit.html',
                    controller: 'ProductDetailsCtrl'
                })
                .state("productNew", {
                    url: "/:locale/product/new/",
                    templateUrl: '/app/NAD/Product/views/edit.html',
                    controller: 'ProductDetailsCtrl'
                })
                .state("productCategory", {
                    url: "/:locale/product/category/:lang/",
                    templateUrl: '/app/NAD/Kernel/views/category.html',
                    controller: 'ProductCategoryCtrl'
                })
                .state("productCategoryEdit", {
                    url: "/:locale/product/category/edit/:lang/:id/",
                    templateUrl: '/app/NAD/Product/views/edit-category.html',
                    controller: 'ProductCategoryDetailsCtrl'
                })
        }])
        .run(['$rootScope', 'Environment', function ($rootScope, Environment) {
            $rootScope.topMenu.push(
                {
                    "ordering": 200,
                    "title": 'Products',
                    "children": {
                        "products": {
                            "ordering": 100,
                            "slug": '/products/',
                            "title": 'Products'
                        },
                        "productCategory": {
                            "ordering": 200,
                            "slug": '/product/category/' + Environment.currentLocale() + '/',
                            "title": 'Categories'
                        }
                    }
                }
            );
        }]);
});