'use strict';

/**
 * @ngdoc overview
 * @name nadApp
 * @description
 *
 * E2E Product test
 */

describe("E2E: Product module tests", function () {
    console.log('Test loaded: Product');

    it('Product route is working', function () {
        browser.get('http://nad.dev/en/products/');
        expect(browser.getTitle()).toEqual('NAD - open source project');
    });

    it('Product categories route is working', function () {
        browser.get('http://nad.dev/en/product/categories/');
        expect(browser.getTitle()).toEqual('NAD - open source project');
    });

    it('Product page route is working', function () {
        browser.get('http://nad.dev/en/product/view/en-nike-baseball-hat-12/');
        expect(browser.getTitle()).toEqual('NAD - open source project');
    });
});