const { chromium } = require('playwright');
const assert = require('node:assert/strict');
(async () => {
    const browser = await chromium.launch({ channel: 'msedge', headless: true });
    try {
        const page = await browser.newPage({ viewport: { width: 1440, height: 1000 } });
        await require('./hide-offers.cjs')(page);
        const errors = [];
        page.on('pageerror', error => errors.push(error.message));
        await page.goto(`http://localhost/newsuperprime-wordpress/services/?lang=en&category_check=${Date.now()}`, { waitUntil: 'networkidle' });
        const filters = page.locator('[data-catalog-filter]');
        assert.equal(await filters.count(), 4);
        const visibleCards = page.locator('.nsp-service-card:not([hidden])');
        assert.equal(await visibleCards.count(), 18);
        for (const [name, count, hero] of [ ['Home Cleaning', 9, 'Home Cleaning'], ['Pest Control', 8, 'Pest Control'], ['Office & Commercial Cleaning', 1, 'Office & Commercial Cleaning'] ]) {
            const button = page.getByRole('button', { name, exact: true }).filter({ has: page.locator('.nsp-filter-dot') });
            await button.click();
            assert.equal(await visibleCards.count(), count);
            assert.equal(await page.locator('.nsp-specialized-card:not([hidden])').count(), count);
            assert.equal(await page.locator('#nsp-catalog-highlights [data-hero-slide]:not([hidden]) h2').innerText(), hero);
            const category = await button.getAttribute('data-catalog-filter');
            const offers = page.locator('.nsp-offer-grid [data-catalog-item]:not([hidden])');
            assert.ok(await offers.count() > 0 && await offers.count() <= 8);
            assert.equal(await offers.evaluateAll((items, key) => items.every(item => item.dataset.serviceCategories.split(' ').includes(key)), category), true);
        }
        await filters.first().click();
        assert.equal(await visibleCards.count(), 18);
        await page.setViewportSize({ width: 390, height: 844 });
        await page.getByRole('button', { name: 'Pest Control', exact: true }).filter({ has: page.locator('.nsp-filter-dot') }).click();
        assert.equal(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth), true);
        await visibleCards.first().locator('[data-nsp-booking]').click();
        await page.waitForSelector('#nsp-service-preview[open]');
        assert.equal(await page.locator('#nsp-preview-title').innerText(), 'Pest Control');
        await page.keyboard.press('Escape');
        await page.goto('http://localhost/newsuperprime-wordpress/services/?lang=ar', { waitUntil: 'networkidle' });
        await page.locator('[data-catalog-filter]').nth(2).click();
        assert.equal(await visibleCards.count(), 8);
        assert.equal(await page.locator('#nsp-catalog-highlights [data-hero-slide]:not([hidden]) h2').innerText(), 'مكافحة الحشرات');
        assert.deepEqual(errors, []);
        console.log('PASS: All/Home/Pest/Office category counts, related packages and hero, category switching, mobile booking, and Arabic RTL.');
    } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exit(1); });
