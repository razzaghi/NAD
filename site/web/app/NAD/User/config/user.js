'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADUser
 * @description     Module config
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("userLogin", {
                url: "/:locale/user/login/",
                templateUrl: '/app/NAD/User/views/login.html',
                controller: 'UserCtrl',
                data: {
                    role: 'guest'
                }
            })
            .state("userRegister", {
                url: "/:locale/user/register/",
                templateUrl: '/app/NAD/User/views/register.html',
                controller: 'UserCtrl',
                data: {
                    role: 'guest'
                }
            })
            .state("userPasswordForgot", {
                url: "/:locale/user/password/forgot/",
                templateUrl: '/app/NAD/User/views/password-forgot.html',
                controller: 'UserCtrl',
                data: {
                    role: 'guest'
                }
            })
            // Authenticated users actions
            .state("userInformation", {
                url: "/:locale/user/information/",
                templateUrl: '/app/NAD/User/views/information/dashboard.html',
                controller: 'UserCtrl',
                data: {
                    role: 'user'
                }

            })
            .state("userInformationEdit", {
                url: "/:locale/user/information/edit/",
                templateUrl: '/app/NAD/User/views/information/edit.html',
                controller: 'UserCtrl',
                data: {
                    role: 'user'
                }

            })
    }]);
});