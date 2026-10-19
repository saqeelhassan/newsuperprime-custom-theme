const { chromium } = require('playwright');
const assert = require('node:assert/strict');
(async () => {
    const browser = await chromium.launch({ channel: 'msedge', headless: true });
    try {
        const page = await browser.newPage({ viewport: { width: 1440, height: 1000 } });
        await require('./hide-offers.cjs')(page);
        await page.goto(`http://localhost/newsuperprime-wordpress/services/?lang=en&directory_check=${Date.now()}`, { waitUntil: 'networkidle' });
        assert.equal(await page.locator('.nsp-service-card').count(), 25);
        const servicesLink = page.locator('.header-navigation-content .main-navigation').getByRole('link', { name: 'Services', exact: true });
        assert.equal(await servicesLink.locator('..').locator(':scope>ul').count(), 0);
        assert.match(await servicesLink.getAttribute('href'), /services\//);
        await page.locator('.nsp-service-card').nth(3).locator('[data-nsp-booking]').click();
        await page.waitForSelector('#nsp-service-preview[open]');
        assert.equal(await page.locator('#nsp-service-preview input[type=radio]').count(), 0);
        assert.equal(await page.locator('#nsp-preview-title').innerText(), 'Carpet & Rug Cleaning');
        await page.keyboard.press('Escape');
        const sofaUrl = await page.locator('.nsp-service-card h3 a').nth(1).getAttribute('href');
        const response = await page.goto(sofaUrl, { waitUntil: 'networkidle' });
        assert.equal(response.status(), 200);
        assert.equal(await page.locator('h1').last().innerText(), 'Sofa Cleaning');
        await page.goto('http://localhost/newsuperprime-wordpress/services/?lang=ar', { waitUntil: 'networkidle' });
        assert.equal(await page.locator('.nsp-service-card').count(), 25);
        assert.equal(await page.locator('.nsp-service-card h3').first().innerText(), 'تنظيف المنازل');
        console.log('PASS: 25 catalog services, direct Services navigation, packages, readable ampersands, service detail URL, and Arabic labels.');
    } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exit(1); });
