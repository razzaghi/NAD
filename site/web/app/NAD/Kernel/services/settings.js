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
 * @description     Grabs application settings from administrator
 */

define(['app'], function (app) {
    console.log('Kernel settings loaded ...');
    angular.module('app')
        .service('settingsService', ['$http', '$rootScope', 'Environment',
            function ($http, $rootScope, Environment) {
                return {
                    getApplicationConfig: function () {
                        var locale = Environment.currentLocale();
                        var url = Environment.settings.api + '/' + locale + '/config/';
                        // console.log(url);
                        return $http.get(url);
                    },
                    getMenu: function () {
                        var locale = Environment.currentLocale();
                        var url = Environment.settings.api + '/' + locale + '/navigation/';
                        //console.log(url);
                        return $http.get(url);
                    }
                };
            }
        ]);
});