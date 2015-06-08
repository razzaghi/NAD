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
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("pages", {
                    url: "/:locale/pages/",
                    templateUrl: '/app/NAD/Kernel/views/collection.html',
                    controller: 'PageCtrl'
                })
                .state("pageEdit", {
                    url: "/:locale/page/edit/:id/",
                    templateUrl: '/app/NAD/Page/views/edit.html',
                    controller: 'PageDetailsCtrl'
                })
                .state("pageNew", {
                    url: "/:locale/page/new/",
                    templateUrl: '/app/NAD/Page/views/edit.html',
                    controller: 'PageDetailsCtrl'
                })
                .state("pageCategory", {
                    url: "/:locale/page/category/:lang/",
                    templateUrl: '/app/NAD/Kernel/views/category.html',
                    controller: 'PageCategoryCtrl'
                })
                .state("pageCategoryEdit", {
                    url: "/:locale/page/category/edit/:lang/:id/",
                    templateUrl: '/app/NAD/Page/views/edit-category.html',
                    controller: 'PageCategoryDetailsCtrl'
                })
        }])
        .run(['$rootScope', 'Environment', function ($rootScope, Environment) {
            $rootScope.topMenu.push(
                {
                    "ordering": 100,
                    "title": 'Pages',
                    "children": {
                        "pages": {
                            "ordering": 100,
                            "slug": '/pages/',
                            "title": 'Pages'
                        },
                        "pageCategory": {
                            "ordering": 200,
                            "slug": '/page/category/' + Environment.currentLocale() + '/',
                            "title": 'Categories'
                        }
                    }
                }
            );
        }]);
});