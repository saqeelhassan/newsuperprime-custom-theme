const { chromium } = require('playwright');
const assert = require('node:assert/strict');
const path = require('node:path');
const base = process.env.WP_TEST_URL || 'http://localhost/newsuperprime-wordpress/';
(async () => {
    const browser = await chromium.launch({ channel: 'msedge', headless: true });
    try {
        const page = await browser.newPage({ viewport: { width: 1440, height: 1000 } });
        await require('./hide-offers.cjs')(page);
        const errors = [];
        page.on('pageerror', error => errors.push(error.message));
        await page.goto(`${base}services/?lang=en`, { waitUntil: 'networkidle' });
        const preview = page.locator('#nsp-service-preview');
        const card = page.locator('.nsp-service-card').first();
        const trigger = card.locator('[data-nsp-booking]');
        const title = await card.locator('h3').innerText();
        await trigger.evaluate(button => {
            button.dataset.packages = JSON.stringify([
                { package_name: 'Standard clean', package_price: 149, package_description: 'Deep cleaning for your space.', package_perk: 'Supplies included' },
                { package_name: 'Complete clean', package_price: 199, package_description: 'A complete clean for larger spaces.', package_perk: 'Extra care included' },
                { package_name: '<img src=x onerror=alert(1)>', package_price: 249, package_description: 'Literal text, safely displayed.' },
            ]);
        });
        await card.locator('.nsp-service-photo').click();
        assert.equal(await preview.evaluate(el => el.open), true);
        assert.equal(await preview.locator('h2').innerText(), title);
        assert.match(await preview.locator('[data-preview-price]').innerText(), /149/);
        assert.equal(await preview.locator('[data-preview-packages] img').count(), 0);
        await preview.locator('input[value="1"]').check();
        assert.match(await preview.locator('[data-preview-price]').innerText(), /199/);
        if (process.env.CATALOG_SCREENSHOTS) await page.screenshot({ path: path.join(process.env.CATALOG_SCREENSHOTS, 'service-preview-desktop.png') });
        await preview.locator('[data-preview-continue]').click();
        await page.waitForSelector('#nsp-booking[open]');
        assert.equal(await page.locator('#nsp-booking input[name=package]:checked').inputValue(), '1');
        assert.equal(await preview.evaluate(el => el.open), false);
        await page.keyboard.press('Escape');
        assert.equal(await card.locator('.nsp-service-photo').evaluate(el => el === document.activeElement), true);
        assert.equal(await page.locator('html').evaluate(el => el.classList.contains('nsp-preview-open') || el.classList.contains('nsp-booking-open')), false);
        await page.setViewportSize({ width: 390, height: 844 });
        await card.locator('h3 a').click();
        assert.equal(await preview.evaluate(el => el.scrollWidth <= el.clientWidth), true);
        assert.equal(await preview.locator('[data-preview-continue]').isVisible(), true);
        if (process.env.CATALOG_SCREENSHOTS) await page.screenshot({ path: path.join(process.env.CATALOG_SCREENSHOTS, 'service-preview-mobile.png') });
        await page.keyboard.press('Escape');
        await trigger.evaluate(button => { button.dataset.packages = '[]'; });
        await trigger.click();
        assert.equal(await preview.locator('[data-preview-quote]').isVisible(), true);
        assert.equal(await preview.locator('[data-preview-continue]').isVisible(), false);
        assert.equal(await preview.locator('[data-preview-price]').textContent(), '');
        await preview.locator('[data-preview-quote]').click();
        assert.equal(await page.locator('#nsp-booking').evaluate(el=>el.open), true);
        assert.equal(await page.locator('#nsp-booking [data-next]').isDisabled(), false);
        await page.keyboard.press('Escape');
        await page.locator('.nsp-specialized-card h3 a').first().click();
        assert.equal(await preview.evaluate(el => el.open), true);
        await page.keyboard.press('Escape');
        await page.goto(`${base}?lang=en`, { waitUntil: 'networkidle' });
        await page.waitForSelector('#nsp-home-services .nsp-service-card');
        const homeRail = page.locator('#nsp-home-services [data-rail=featured]');
        await page.locator('#nsp-home-services [data-rail-next]').click();
        await page.waitForFunction(() => document.querySelector('#nsp-home-services [data-rail]').scrollLeft > 0);
        assert.ok(await homeRail.evaluate(el => el.scrollLeft) > 0);
        await page.locator('#nsp-home-services .nsp-service-photo').first().click();
        assert.equal(await page.locator('#nsp-service-preview').evaluate(el => el.open), true);
        await page.keyboard.press('Escape');
        assert.deepEqual(errors, []);
        console.log('PASS: card/image/title clicks, package selection, safe text, wizard handoff, focus, scroll unlock, mobile, empty packages, specialized services, and homepage carousel.');
    } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exit(1); });
