'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADFrontendUser
 * @description     Module configuration
 */

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("frontendUsers", {
                    url: "/:locale/users/site/",
                    templateUrl: '/app/NAD/Kernel/views/collection.html',
                    controller: 'FrontendUserCtrl'
                })
                .state("frontendUserEdit", {
                    url: "/:locale/users/site/edit/:id/",
                    templateUrl: '/app/NAD/FrontendUser/views/edit.html',
                    controller: 'FrontendUserDetailCtrl'
                })
                .state("frontendUserNew", {
                    url: "/:locale/users/site/new/",
                    templateUrl: '/app/NAD/Product/views/edit.html',
                    controller: 'FrontendUserDetailCtrl'
                })
        }])
        .run(['$rootScope', 'Environment', function ($rootScope, Environment) {
            $rootScope.topMenu.push(
                {
                    "ordering": 300,
                    "title": 'Users',
                    "slug": '/users/site/'
                }
            );
        }]);
});