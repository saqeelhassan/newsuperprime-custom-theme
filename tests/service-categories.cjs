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
        assert.equal(await filters.count(), 7);
        const visibleCards = page.locator('.nsp-service-card:not([hidden])');
        assert.equal(await visibleCards.count(), 25);
        for (const [name, count, hero] of [ ['Cleaning', 11, 'Home Cleaning'], ['Pest Control', 9, 'Pest Control'], ['AC Services', 1, 'AC Services'], ['Commercial', 1, 'Office Cleaning'], ['Relocation', 1, 'Home Shifting'], ['Maintenance', 2, 'Car Detailing'] ]) {
            const button = page.getByRole('button', { name, exact: true }).filter({ has: page.locator('.nsp-filter-dot') });
            await button.click();
            assert.equal(await visibleCards.count(), count);
            assert.equal(await page.locator('.nsp-specialized-card:not([hidden])').count(), count);
            assert.equal(await page.locator('#nsp-catalog-highlights [data-hero-slide]:not([hidden]) h2').innerText(), hero);
            const category = await button.getAttribute('data-catalog-filter');
            const offers = page.locator('.nsp-offer-grid [data-catalog-item]:not([hidden])');
            assert.ok(await offers.count() <= 8);
            if (['AC Services','Commercial','Relocation','Maintenance'].includes(name)) assert.equal(await offers.count(), 0);
            else assert.ok(await offers.count() > 0);
            assert.equal(await offers.evaluateAll((items, key) => items.every(item => item.dataset.serviceCategories.split(' ').includes(key)), category), true);
        }
        await filters.first().click();
        assert.equal(await visibleCards.count(), 25);
        await page.setViewportSize({ width: 390, height: 844 });
        await page.getByRole('button', { name: 'Pest Control', exact: true }).filter({ has: page.locator('.nsp-filter-dot') }).click();
        assert.equal(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth), true);
        await visibleCards.first().locator('[data-nsp-booking]').click();
        await page.waitForSelector('#nsp-service-preview[open]');
        assert.equal(await page.locator('#nsp-preview-title').innerText(), 'Pest Control');
        await page.keyboard.press('Escape');
        await page.goto('http://localhost/newsuperprime-wordpress/services/?lang=ar', { waitUntil: 'networkidle' });
        await page.locator('[data-catalog-filter]').nth(2).click();
        assert.equal(await visibleCards.count(), 9);
        assert.equal(await page.locator('#nsp-catalog-highlights [data-hero-slide]:not([hidden]) h2').innerText(), 'مكافحة الحشرات');
        assert.deepEqual(errors, []);
        console.log('PASS: All six category counts, related packages and hero, category switching, mobile booking, and Arabic RTL.');
    } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exit(1); });
