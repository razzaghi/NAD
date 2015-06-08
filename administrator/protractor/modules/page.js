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
    var urlToCheck = 'http://admin.nad.dev/en/pages/';
    var textToCheck = 'Pages';

    // == Collection route ==
    it('Collection route is working', function () {
        browser.get(urlToCheck);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe(textToCheck);
    });

    // == Edit item route ==
    it('Edit route is working', function () {
        browser.get(urlToCheck);

        element(by.css('.ui-grid-canvas button')).click().then(function () {
            browser.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/edit/")).toBeGreaterThan(0);
            });
        });
    });

    // == New item route ==
    it('New item route is working', function () {
        browser.get(urlToCheck);

        element(by.css('.add-new-item')).click().then(function () {
            browser.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/new/")).toBeGreaterThan(0);
            });
        });
    });

    // == Page category route ==
    it('Page categories route is working', function () {
        browser.get('http://admin.nad.dev/en/page/category/en/');

        element(by.css('.glyphicon-edit')).click().then(function () {
            browser.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/edit/en/")).toBeGreaterThan(0);
            });
        });
    });

});