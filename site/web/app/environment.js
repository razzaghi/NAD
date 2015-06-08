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
 * @description     Environment vars
 */

define(['angular'],
    function (angular) {
        'use strict';
        console.log('Environment loaded ...');
        angular.module('environment', [])
            .service('Environment', function () {
                return {
                    settings: {
                        media: 'http://api.' + document.domain + '/media/product',
                        api: 'http://api.' + document.domain + '/api',
                        locale: {
                            "primary": 'en',
                            "available": ['en', 'es', 'ru']
                        }
                    },
                    currentLocale: function () {
                        var locale = window.location.pathname.replace(/^\/([^\/]*).*$/, '$1');
                        if (this.settings.locale.available.indexOf(locale) == -1) {
                            locale = this.settings.locale.primary;
                        }
                        return locale;
                    }
                }
            }
        )
    });