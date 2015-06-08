'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADCart
 * @description     Module configuration
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("contact", {
                url: "/:locale/contact/",
                templateUrl: '/app/NAD/Contact/views/contact.html',
                controller: 'ContactCtrl'
            });
    }]);
});