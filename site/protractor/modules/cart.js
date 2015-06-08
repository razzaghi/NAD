'use strict';

/**
 * @ngdoc overview
 * @name nadApp
 * @description
 *
 * E2E Cart test
 */

describe("E2E: Cart module tests", function () {
    console.log('Test loaded: Cart');

    it('Cart in route is working', function () {
        browser.get('http://nad.dev/en/cart/');
        expect(browser.getTitle()).toEqual('NAD - open source project');
    });

});