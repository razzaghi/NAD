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
 * @description     Module configuration
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("pages", {
                url: "/:locale/pages/",
                templateUrl: '/app/NAD/Page/views/page.html',
                controller: 'PageCtrl'
            })
            .state("pageView", {
                url: "/:locale/page/view/:pageId/",
                templateUrl: '/app/NAD/Page/views/page-detail.html',
                controller: 'PageDetailCtrl'
            })
            .state("pageCategories", {
                url: "/:locale/page/categories/",
                templateUrl: '/app/NAD/Page/views/category.html',
                controller: 'PageCategoryCtrl'
            })
            .state("pageCategoryView", {
                url: "/:locale/page/category/:categoryId/",
                templateUrl: '/app/NAD/Page/views/category-detail.html',
                controller: 'PageCategoryDetailCtrl'
            });
    }]);
});