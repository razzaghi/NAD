'use strict';

/**
 * @ngdoc overview
 * @name nadApp
 * @description
 *
 * E2E Page test
 */

describe("E2E: Page module tests", function () {
    console.log('Test loaded: Page');

    it('Page route is working', function () {
        browser.get('http://nad.dev/en/pages/');
        expect(browser.getTitle()).toEqual('NAD - open source project');
    });

    it('Page categories route is working', function () {
        browser.get('http://nad.dev/en/page/categories/');
        expect(browser.getTitle()).toEqual('NAD - open source project');
    });

    it('About Us page route is working', function () {
        browser.get('http://nad.dev/en/page/view/en-about-nad/');
        expect(browser.getTitle()).toEqual('About Us');
    });
});