'use strict';

/**
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            NADPage
 * @description     PageCategoryCtrl
 */

define(['app'], function (app) {
    app.controller('PageCategoryCtrl', function ($scope, $stateParams, $state, Environment) {

        $scope.sectionName = 'Page categories';
        $scope.categoryJson = Environment.settings.api + '/page/category/?locale=' + $stateParams.lang;
        $scope.categoryUpdate = Environment.settings.api + '/page/category/node/?locale=' + $stateParams.lang;

        $scope.editNode = function (id) {
            $state.transitionTo('pageCategoryEdit', {
                locale: Environment.currentLocale(),
                lang: $stateParams.lang,
                id: id
            });
        };

        $scope.changeCategoryLocale = function (lang) {
            $state.transitionTo('pageCategory', {
                locale: Environment.currentLocale(),
                lang: lang
            });
        };
    });
});