'use strict';

/**
 * @ngdoc overview
 * @name nadApp
 * @description
 *
 * E2E Contact test
 */

describe("E2E: Contact module tests", function () {
    console.log('Test loaded: Contact');

    it('Contact route is working', function () {
        browser.get('http://nad.dev/en/contact/');
        expect(browser.getTitle()).toEqual('NAD - open source project');
    });
});