'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADAuth
 * @description     Module config
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("userLogin", {
                url: "/:locale/user/login/",
                templateUrl: '/app/NAD/Auth/views/login.html',
                controller: 'AuthCtrl',
                data: {
                    role: 'guest'
                }
            })
    }]);
});