'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADAddressing
 * @description     Module configuration
 */

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("countries", {
                    url: "/:locale/addressing/country/",
                    templateUrl: '/app/NAD/Kernel/views/collection.html',
                    controller: 'AddressingCountryCtrl'
                })
                .state("countryEdit", {
                    url: "/:locale/addressing/country/edit/:id/",
                    templateUrl: '/app/NAD/Addressing/views/edit-country.html',
                    controller: 'AddressingCountryDetailsCtrl'
                })
                .state("countryNew", {
                    url: "/:locale/addressing/country/new/",
                    templateUrl: '/app/NAD/Addressing/views/edit-country.html',
                    controller: 'AddressingCountryDetailsCtrl'
                })

                .state("regions", {
                    url: "/:locale/addressing/region/",
                    templateUrl: '/app/NAD/Kernel/views/collection.html',
                    controller: 'AddressingRegionCtrl'
                })
                .state("regionEdit", {
                    url: "/:locale/addressing/region/edit/:id/",
                    templateUrl: '/app/NAD/Addressing/views/edit-region.html',
                    controller: 'AddressingRegionDetailsCtrl'
                })
                .state("regionNew", {
                    url: "/:locale/addressing/region/new/",
                    templateUrl: '/app/NAD/Addressing/views/edit-region.html',
                    controller: 'AddressingRegionDetailsCtrl'
                })

                .state("cities", {
                    url: "/:locale/addressing/city/",
                    templateUrl: '/app/NAD/Kernel/views/collection.html',
                    controller: 'AddressingCityCtrl'
                })
                .state("cityEdit", {
                    url: "/:locale/addressing/city/edit/:id/",
                    templateUrl: '/app/NAD/Addressing/views/edit-city.html',
                    controller: 'AddressingCityDetailsCtrl'
                })
                .state("cityNew", {
                    url: "/:locale/addressing/city/new/",
                    templateUrl: '/app/NAD/Addressing/views/edit-city.html',
                    controller: 'AddressingCityDetailsCtrl'
                })
        }])
        .run(['$rootScope', 'Environment', function ($rootScope, Environment) {
            $rootScope.topMenu.push(
                {
                    "ordering": 900,
                    "title": 'Addresses',
                    "children": {
                        "countries": {
                            "ordering": 100,
                            "slug": '/addressing/country/',
                            "title": 'Countries'
                        },
                        "regions": {
                            "ordering": 200,
                            "slug": '/addressing/region/',
                            "title": 'Regions'
                        },
                        "cities": {
                            "ordering": 300,
                            "slug": '/addressing/city/',
                            "title": 'Cities'
                        }
                    }
                }
            );
        }]);
});