'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADOrder
 * @description     Checkout service
 */

define(['app'], function (app) {
    app.service('checkoutService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                init: function () {
                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/order/checkout/init.json';
                    console.log(url);
                    return $http.get(url);
                },
                orderSubmit: function (form) {
                    var formData = {};
                    formData['billing_country'] = encodeURIComponent(form.billing_country.$modelValue);
                    formData['billing_region'] = encodeURIComponent(form.billing_region.$modelValue);
                    formData['billing_city'] = encodeURIComponent(form.billing_city.$modelValue);
                    formData['billing_phone'] = encodeURIComponent(form.billing_phone.$modelValue);
                    formData['billing_comment'] = encodeURIComponent(form.billing_comment.$modelValue);
                    formData['payment_method'] = encodeURIComponent(form.payment_method.$modelValue);

                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/order/submit.json';
                    console.log(formData);
                    console.log(url);
                    return $http.post(url, formData);
                },
                getCountries: function () {
                    var url = Environment.settings.api + '/addressing/country/list.json';
                    console.log(url);
                    return $http.get(url);
                },
                getRegions: function () {
                    var url = Environment.settings.api + '/addressing/region/list.json';
                    console.log(url);
                    return $http.get(url);
                },
                getCities: function () {
                    var url = Environment.settings.api + '/addressing/city/list.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});