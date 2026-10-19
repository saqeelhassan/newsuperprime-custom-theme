/* Live local catalog check. Does not save data or send booking requests. */
const { chromium } = require('playwright');
const path = require('node:path');
const assert = require('node:assert/strict');
const base = process.env.WP_TEST_URL || 'http://localhost/newsuperprime-wordpress/';
(async () => {
    const browser = await chromium.launch({ channel: 'msedge', headless: true });
    try {
        const page = await browser.newPage({ viewport: { width: 1440, height: 1050 } });
        await require('./hide-offers.cjs')(page);
        const errors = [];
        page.on('pageerror', error => errors.push(error.message));
        await page.goto(`${base}services/?lang=en`, { waitUntil: 'networkidle' });
        const root = page.locator('#nsp-catalog');
        await root.waitFor();
        const cards = root.locator('.nsp-service-card');
        const count = await cards.count();
        assert.ok(count > 0, 'Publish a service before running this check');
        await root.locator('[data-catalog-filter]').nth(1).click();
        assert.equal(await root.locator('.nsp-service-card:not([hidden])').count(), 9);
        await root.locator('[data-catalog-filter=all]').click();
        if (await root.locator('[data-hero-dot]').count() > 1) {
            await root.locator('[data-hero-dot]').nth(1).click();
            assert.equal(await root.locator('[data-hero-slide]').nth(1).isVisible(), true);
        }
        await root.locator('[data-catalog-city=Khobar]').first().click();
        const trigger = cards.first().locator('[data-nsp-booking]');
        // Client fixture tests preselection without changing the database.
        await trigger.evaluate(button => {
            button.dataset.packages = JSON.stringify([{ package_name: 'Test package', package_price: 199 }, { package_name: 'Second package', package_price: 249 }]);
            button.dataset.packageIndex = '1';
        });
        await trigger.click();
        await page.waitForSelector('#nsp-service-preview[open]');
        assert.equal(await page.locator('#nsp-service-preview input:checked').inputValue(), '1');
        await page.locator('[data-preview-continue]').click();
        await page.waitForSelector('#nsp-booking[open]');
        assert.equal(await page.locator('#nsp-booking input[name=package]:checked').inputValue(), '1');
        await page.locator('#nsp-booking [data-next]').click();
        assert.equal(await page.locator('#nsp-booking input[name=city]:checked').inputValue(), 'Khobar');
        await page.locator('#nsp-booking [data-close]').click();
        await root.scrollIntoViewIfNeeded();
        if (process.env.CATALOG_SCREENSHOTS) await root.screenshot({ path: path.join(process.env.CATALOG_SCREENSHOTS, 'catalog-desktop.png') });
        await page.setViewportSize({ width: 390, height: 844 });
        assert.equal(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth), true, 'No horizontal page overflow on phones');
        if (process.env.CATALOG_SCREENSHOTS) await root.screenshot({ path: path.join(process.env.CATALOG_SCREENSHOTS, 'catalog-mobile.png') });
        await page.goto(`${base}services/?lang=ar`, { waitUntil: 'networkidle' });
        assert.equal(await page.locator('html').getAttribute('dir'), 'rtl');
        assert.equal(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth), true);
        await page.locator('[data-catalog-city=Jubail]').first().click();
        await page.locator('.nsp-service-card [data-nsp-booking]').first().click();
        await page.waitForSelector('#nsp-service-preview[open]');
        await page.keyboard.press('Escape');
        assert.deepEqual(errors, []);
        console.log(`PASS: ${count} live services; filters, hero, package/city preselection, booking, mobile overflow, and Arabic RTL.`);
    } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exit(1); });
