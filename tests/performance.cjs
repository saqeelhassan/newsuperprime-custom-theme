/* Live asset/loading regressions. Does not save content or submit forms. */
const { chromium } = require('playwright');
const assert = require('node:assert/strict');
const base = process.env.WP_TEST_URL || 'http://localhost/newsuperprime-wordpress/';
(async () => {
    const browser = await chromium.launch({ channel: 'msedge', headless: true });
    try {
        const page = await browser.newPage({ viewport: { width: 1440, height: 1000 } });
        await require('./hide-offers.cjs')(page);
        const errors = [];
        page.on('pageerror', error => errors.push(error.message));
        for (const route of ['', 'services/', 'about/', 'projects/', 'contact/', 'faq/']) {
            await page.goto(`${base}${route}?lang=en&performance=${Date.now()}`, { waitUntil: 'networkidle' });
            const assets = await page.evaluate(() => ({
                scripts: [...document.scripts].filter(s => s.src).map(s => ({ id: s.id, src: s.src, defer: s.defer, inBody: document.body.contains(s) })),
                styles: [...document.querySelectorAll('link[rel=stylesheet]')].map(s => s.href),
                jquery: jQuery.fn.jquery,
            }));
            assert.equal(assets.jquery, '3.7.1');
            assert.equal(assets.scripts.filter(s => /\/jquery\/jquery(?:\.min)?\.js/.test(s.src)).length, 1);
            assert(assets.scripts.some(s => s.id === 'jquery-migrate-js'));
            assert(!assets.scripts.some(s => /theme-3\/assets\/js\/jquery\.min\.js|wp-emoji/.test(s.src)));
            const html = await page.content();
            assert(!/wp-emoji-release|wp-emoji-loader|wp-emoji-styles/.test(html));
            for (const script of assets.scripts.filter(s => s.id.startsWith('nsp-'))) {
                assert(script.inBody, script.id + ' in footer');
                assert(script.defer, script.id + ' deferred');
                assert(/[?&]ver=\d+/.test(script.src), script.id + ' filemtime version');
            }
            const has = id => assets.scripts.some(s => s.id === id + '-js');
            assert.equal(await page.evaluate(() => Boolean(nspData.ripplesUrl)), route === '');
            if (has('nsp-ripples')) assert.equal(route, '');
            assert.equal(has('nsp-service-catalog'), ['', 'services/'].includes(route));
            assert.equal(has('nsp-slick'), ['', 'about/'].includes(route));
            assert.equal(has('nsp-counterup'), ['', 'about/'].includes(route));
            assert.equal(has('nsp-appear'), route === 'about/');
            assert.equal(has('nsp-filterizr'), route === 'projects/');
            assert(!has('nsp-inputarrow') && !has('nsp-magnific'));
            assert(!assets.scripts.some(s => /gmap3|maps\.googleapis/.test(s.src)));
            assert(!assets.styles.some(src => /video\.min\.css/.test(src)));
            if (route === '') assert(await page.locator('.slick-initialized').count() >= 2);
            if (route === 'projects/') {
                const category = page.locator('.filtr-button').nth(1);
                if (await category.count()) {
                    await category.click();
                    await page.waitForTimeout(600);
                    assert(await category.evaluate(el => el.classList.contains('filtr-active')));
                    const key = await category.getAttribute('data-filter');
                    const visible = await page.locator('.filtr-item').evaluateAll(items => items.filter(el => getComputedStyle(el).opacity !== '0' && getComputedStyle(el).visibility !== 'hidden').map(el => el.dataset.category));
                    assert(visible.length > 0);
                    assert(visible.every(value => value.split(', ').includes(key)));
                }
            }
            if (route === 'faq/') {
                const button = page.locator('.accordion-button').nth(1);
                await button.click();
                await page.waitForTimeout(400);
                assert.equal(await button.getAttribute('aria-expanded'), 'true');
            }
        }
        // Exercise conditionally retained legacy plugins with small client-only fixtures.
        await page.addScriptTag({ url: `${base}wp-content/themes/newsuperprime-theme-3/assets/js/jquery.magnific-popup.min.js` });
        await page.addScriptTag({ url: `${base}wp-content/themes/newsuperprime-theme-3/assets/js/jquery.inputarrow.js` });
        await page.evaluate(() => {
            const root = jQuery('<div id="performance-fixture"><div id="performance-inline">Popup content</div><input type="number" value="1"></div>').appendTo('body');
            root.find('input').inputarrow();
            jQuery.magnificPopup.open({ items: { src: '#performance-inline', type: 'inline' } });
        });
        assert(await page.locator('.mfp-wrap').isVisible());
        await page.evaluate(() => { jQuery.magnificPopup.close(); document.querySelector('#performance-fixture').remove(); });
        await page.goto(`${base}?lang=ar`, { waitUntil: 'networkidle' });
        await page.evaluate(async () => {
            for (const [family, weight] of [['Font Awesome 5 Pro', 300], ['Font Awesome 5 Pro', 400], ['Font Awesome 5 Pro', 900], ['Font Awesome 5 Brands', 400]]) await document.fonts.load(`${weight} 16px "${family}"`);
        });
        const fonts = await page.evaluate(() => performance.getEntriesByType('resource').map(e => e.name).filter(url => /fa-(?:light|regular|solid|brands)/.test(url)));
        assert(fonts.length >= 4 && fonts.every(url => url.includes('.woff2')));
        await page.setViewportSize({ width: 390, height: 844 });
        assert(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        assert.deepEqual(errors, []);
        console.log('PASS: core jQuery + Migrate, footer/defer/versioning, conditional assets, no emoji, Slick, Filterizr, FAQ, Magnific, Inputarrow, WOFF2 and RTL/mobile.');
    } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exit(1); });
