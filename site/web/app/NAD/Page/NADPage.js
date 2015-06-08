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
 * @description     Page module
 */

define(['app',
    './config/page',
    './controllers/page',
    './controllers/pageDetails',
    './controllers/pageCategory',
    './controllers/pageCategoryDetails',
    './services/page',
    './services/pageCategory'
], function (app) {
    console.log('Page module loaded ...');
});