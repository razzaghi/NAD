'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADProduct
 * @description     ...
 */

define(['app'], function (app) {
    app.service('productCategoryService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                getCategories: function ($scope) {
                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/product/category/?limit=' + $scope.pageLimit + '&current=' + $scope.paginationPage;
                    console.log(url);
                    return $http.get(url);
                },
                getCategory: function (categoryId) {
                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/product/category/' + categoryId;
                    console.log(url);
                    return $http.get(url);
                },
                getProductCategoryTree: function () {
                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/product/category/tree/';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});