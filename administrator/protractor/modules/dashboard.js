'use strict';

/**
 * @ngdoc overview
 * @name nadApp
 * @description
 *
 * E2E Dashboard test
 */

describe("E2E: Dashboard module tests", function () {
    console.log('Test loaded: Dashboard');
    var testUrl = 'http://admin.nad.dev/en/';

    it('Dashboard route is working', function () {
        browser.get(testUrl);
        var el = element(By.css('.homepage-content'));

        expect(el.getText()).not.toBeNull();
    });

});