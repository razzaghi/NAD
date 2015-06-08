'use strict';

/**
 * @ngdoc overview
 * @name nadApp
 * @description
 *
 * E2E Homepage test
 */

describe("E2E: We check that our app is feeling nice", function () {
    console.log('Test loaded: Homepage');

    it('should have a title', function () {
        browser.get('http://nad.dev/en/');
        expect(browser.getTitle()).toEqual('NAD - open source project');
    });
});