'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADSearch
 * @description     Module config
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("search", {
                url: '/:locale/search/:query',
                templateUrl: '/app/NAD/Search/views/search.html',
                controller: 'SearchCtrl'
            });
    }]);
});