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
 * @description     Display tree collections with fancyTree
 */

define(['app'], function (app) {
    angular.module('app')
        .directive('nadFancyTree', ['$timeout', function ($timeout) {
            return {
                restrict: 'EA',
                scope: {
                    lang: "@lang"
                },
                templateUrl: '/app/NAD/Kernel/views/fancyTree.html'
            };
        }]);
});