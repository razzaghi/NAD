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
 * @description     Kernel module, module contains data that we cant decompose into module
 */

define(['app',
    './config/resource',
    './services/settings',
    './services/init',
    './filters/main'
], function (app) {
    console.log('----------- Kernel Loaded! -----------');
});

