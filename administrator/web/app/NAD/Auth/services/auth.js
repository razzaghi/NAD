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
 * @description     ...
 */

define(['app'], function (app) {
    app.service('authService', ['$http', 'Environment', function ($http, Environment) {
        return {
            signout: function () {
                var url = Environment.settings.api + '/user/logout/';
                console.log(url);
                return $http.get(url);
            },
            login: function (username, password) {
                var url = Environment.settings.api + '/user/login/?username=' + username + '&password=' + password;
                console.log(url);
                return $http.get(url);
            },
            getUserInformation: function () {
                var url = Environment.settings.api + '/user/information/';
                // console.log(url);
                return $http.get(url);
            }
        };
    }]);
});