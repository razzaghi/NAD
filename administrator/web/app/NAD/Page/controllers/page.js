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
 * @description     PageCtrl
 */

define(['app'], function (app) {
    app.controller('PageCtrl', ['$state', '$scope', 'resourceService', 'collectionService', 'Environment', 'notify',
        function ($state, $scope, resourceService, collectionService, Environment, notify) {

            var itemService = new resourceService('page');

            $scope.collectionTitle = 'Pages';
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [
                {name: 'id', enableColumnMenu: false, width: '100'},
                {name: 'locale', enableColumnMenu: false, width: '15%'},
                {name: 'title', enableColumnMenu: false},
                {name: 'meta_url', enableColumnMenu: false},
                {name: 'status', enableColumnMenu: false},
                {name: 'created_at', enableColumnMenu: false},
                {
                    name: 'action',
                    enableSorting: false,
                    enableFiltering: false,
                    enableColumnMenu: false,
                    width: '100',
                    cellTemplate: collectionService.actionTemplate()
                }
            ];
            $scope.gridOptions = collectionService.gridOptions($scope);

            // === Item Action ===
            $scope.editDetails = function (id) {
                $state.transitionTo('pageEdit', {locale: Environment.currentLocale(), id: id});
            };
            $scope.newItem = function () {
                $state.transitionTo('pageNew', {locale: Environment.currentLocale()});
            };

            // === Load collection from remote ===
            $scope.loadCollection = function (pageNumber) {
                collectionService.loadCollection($scope, itemService, pageNumber);
            };
            $scope.loadCollection();

        }]);
});