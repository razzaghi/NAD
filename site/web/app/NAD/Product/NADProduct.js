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
 * @description     Product module
 */

define(['app',
    './config/product',
    './controllers/product',
    './controllers/productDetails',
    './controllers/productCategory',
    './controllers/productCategoryDetails',
    './services/product',
    './services/productCategory'
], function (app) {
    console.log('Product module loaded ...');
});