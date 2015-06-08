'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADHomepage
 * @description     ...
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("homepage", {
                url: "/:locale/",
                templateUrl: '/app/NAD/Homepage/views/homepage.html',
                controller: 'HomepageCtrl'
            });
    }]);
});