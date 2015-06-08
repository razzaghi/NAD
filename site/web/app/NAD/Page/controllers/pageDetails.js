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
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('PageDetailCtrl', function ($scope, $stateParams, pageService, $rootScope) {
        var pageURL = $stateParams.pageId;
        var handleSuccess = function (data, status) {
            $scope.pageDetails = data;
            $rootScope.pageTitle = $scope.pageDetails.title;

            // Disqus comments
            window.disqus_shortname = $rootScope.disqusShortname;
            $scope.showComments = $rootScope.disqusStatus;
        };
        pageService.getPageByURL(pageURL).success(handleSuccess);
    });
});