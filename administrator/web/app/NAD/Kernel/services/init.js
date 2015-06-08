'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADKernel
 * @description     Most important data are loaded here
 */

define(['app'], function (app) {
    console.log('Kernel init service loaded ...');
    angular.module('app')
        .service('initService', ['$http', '$rootScope', 'Environment',
            function ($http, $rootScope, Environment) {
                return {
                    launch: function () {
                        console.log('----------- NAD Loaded! -----------');
                        $rootScope.pageTitle = Environment.settings.pageTitle;
                        $rootScope.availableLocales = Environment.settings.locale.available;
                        $rootScope.locale = Environment.currentLocale();
                        $rootScope.topMenu = [];
                    }
                }
            }
        ]);
});