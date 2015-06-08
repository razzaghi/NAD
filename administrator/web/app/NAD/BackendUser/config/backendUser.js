'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADBackendUser
 * @description     Module configuration
 */

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("backendUsers", {
                    url: "/:locale/users/administrator/",
                    templateUrl: '/app/NAD/Kernel/views/collection.html',
                    controller: 'BackendUserCtrl'
                })
                .state("backendUserEdit", {
                    url: "/:locale/users/administrator/edit/:id/",
                    templateUrl: '/app/NAD/BackendUser/views/edit.html',
                    controller: 'BackendUserDetailCtrl'
                })
                .state("backendUserNew", {
                    url: "/:locale/users/administrator/new/",
                    templateUrl: '/app/NAD/Product/views/edit.html',
                    controller: 'BackendUserDetailCtrl'
                })
        }])
        .run(['$rootScope', 'Environment', function ($rootScope, Environment) {
            $rootScope.topMenu.push(
                {
                    "ordering": 300,
                    "title": 'Admin users',
                    "slug": '/users/administrator/'
                }
            );
        }]);
});