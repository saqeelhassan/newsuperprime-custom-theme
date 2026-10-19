const { chromium } = require('playwright');
const assert = require('node:assert/strict');
(async () => {
    const browser = await chromium.launch({ channel: 'msedge', headless: true });
    try {
        const page = await browser.newPage({ viewport: { width: 1440, height: 1000 } });
        const errors = [];
        page.on('pageerror', error => errors.push(error.message));
        await page.goto(`http://localhost/newsuperprime-wordpress/?lang=en&offer_check=${Date.now()}`, { waitUntil: 'networkidle' });
        const popup = page.locator('#nsp-special-offers');
        await popup.waitFor({ state: 'visible' });
        assert.equal(await popup.locator('[data-offer-slide]').count(), 4);
        const prices = await popup.locator('.nsp-offer-price').allTextContents();
        assert.deepEqual(prices.map(value => value.trim()), ['199 SAR', '149 SAR', '199 SAR', '199 SAR']);
        for (let index = 0; index < 4; index++) {
            await popup.locator(`[data-offer-dot="${index}"]`).click();
            assert.equal(await popup.locator('[data-offer-slide]').nth(index).isVisible(), true);
        }
        await popup.locator('[data-offers-next]').click();
        assert.equal(await popup.locator('[data-offer-slide]').first().isVisible(), true);
        await page.keyboard.press('ArrowRight');
        assert.equal(await popup.locator('[data-offer-slide]').nth(1).isVisible(), true);
        await page.screenshot({ path: '.booking-build-cache/special-offers-desktop.png' });
        await popup.locator('[data-offer-slide]').nth(1).locator('[data-nsp-booking]').click();
        await page.waitForSelector('#nsp-service-preview[open]');
        assert.equal(await popup.evaluate(el => el.open), false);
        assert.match(await page.locator('#nsp-service-preview [data-preview-price]').innerText(), /149/);
        const chosen = await page.locator('#nsp-service-preview input:checked').inputValue();
        await page.locator('[data-preview-continue]').click();
        await page.waitForSelector('#nsp-booking[open]');
        assert.equal(await page.locator('#nsp-booking input[name=package]:checked').inputValue(), chosen);
        assert.match(await page.locator('#nsp-booking input[name=package]:checked').locator('..').innerText(), /5 Seater Sofa/);
        await page.keyboard.press('Escape');
        assert.equal(await page.locator('html').evaluate(el => el.classList.contains('nsp-offers-open') || el.classList.contains('nsp-preview-open') || el.classList.contains('nsp-booking-open')), false);
        // Returning visitors must not see the popup on other pages or reloads.
        await page.goto(`http://localhost/newsuperprime-wordpress/about/?lang=en&offer_check=${Date.now()}`, { waitUntil: 'networkidle' });
        await page.waitForTimeout(2800);
        assert.equal(await popup.evaluate(el => el.open), false, 'Returning visitors must not see the offer');
        await page.reload({ waitUntil: 'networkidle' });
        await page.waitForTimeout(2800);
        assert.equal(await popup.evaluate(el => el.open), false);
        await popup.evaluate(el => localStorage.removeItem(el.dataset.visitorKey));
        await page.setViewportSize({ width: 390, height: 844 });
        await page.goto(`http://localhost/newsuperprime-wordpress/contact/?lang=ar&offer_check=${Date.now()}`, { waitUntil: 'networkidle' });
        await popup.waitFor({ state: 'visible' });
        assert.equal(await popup.getAttribute('dir'), 'rtl');
        assert.equal(await popup.evaluate(el => el.scrollWidth <= el.clientWidth), true);
        assert.equal(await popup.locator('[data-offer-slide]').first().locator('[data-nsp-booking]').isVisible(), true);
        await page.screenshot({ path: '.booking-build-cache/special-offers-mobile.png' });
        await popup.locator('[data-offers-close]').click();
        await popup.evaluate(el => localStorage.removeItem(el.dataset.visitorKey));
        await page.goto(`http://localhost/newsuperprime-wordpress/about/?lang=en&offer_check=${Date.now()}`, { waitUntil: 'domcontentloaded' });
        await page.locator('#nsp-booking').evaluate(el => el.showModal());
        await page.waitForTimeout(2800);
        assert.equal(await popup.evaluate(el => el.open), false, 'An active booking must not be interrupted');
        await page.keyboard.press('Escape');
        assert.deepEqual(errors, []);
        console.log('PASS: automatic offers on home/other pages, all four exact prices, dots/arrows/keyboard, offer package handoff, scroll unlock, first-visitor persistence, repeat-visit suppression, and mobile Arabic layout.');
    } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exit(1); });
