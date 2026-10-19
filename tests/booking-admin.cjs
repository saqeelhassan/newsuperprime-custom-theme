const { chromium } = require('playwright');
const { execFileSync } = require('node:child_process');
const path = require('node:path');
const assert = require('node:assert/strict');
(async () => {
    const markup = execFileSync('php', [path.join(__dirname, 'booking-admin.php'), '--markup'], { encoding: 'utf8' });
    const browser = await chromium.launch({ channel: 'msedge', headless: true });
    try {
        const page = await browser.newPage();
        await page.setContent(`<form>${markup}<button type="submit">Update</button></form>`);
        await page.addScriptTag({ path: path.resolve(__dirname, '../assets/js/booking-admin.js') });
        const rows = page.locator('[data-package-rows] fieldset');
        assert.equal(await rows.count(), 1);
        await page.click('[data-add-package]');
        assert.equal(await rows.count(), 2);
        assert.equal(await page.locator('form').evaluate(form => form.checkValidity()), false);
        await rows.nth(1).locator('input[type=text]').first().fill('Office cleaning');
        await rows.nth(1).locator('input[type=number]').fill('250');
        assert.equal(await page.locator('form').evaluate(form => form.checkValidity()), true);
        await rows.first().locator('[data-remove-package]').click();
        await page.click('[data-add-package]');
        const names = await rows.locator('input[type=number]').evaluateAll(inputs => inputs.map(input => input.name));
        assert.equal(new Set(names).size, 2, 'Added rows must keep unique indices after removal');
        await rows.first().locator('[data-remove-package]').click();
        await rows.first().locator('[data-remove-package]').click();
        assert.equal(await page.locator('[data-empty-packages]').isVisible(), true);
        console.log('PASS: admin editor renders saved packages; add, remove, required inputs, unique rows, and empty state.');
    } finally { await browser.close(); }
})().catch(err => { console.error(err); process.exit(1); });
