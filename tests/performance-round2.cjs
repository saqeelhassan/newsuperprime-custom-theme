const { chromium } = require('playwright');
const assert = require('node:assert/strict');
const fs = require('node:fs');
(async () => {
    const browser = await chromium.launch({ channel:'msedge', headless:true });
    try {
        const page = await browser.newPage({ viewport:{width:1440,height:1000} });
        await require('./hide-offers.cjs')(page);
        const errors = [];
        page.on('pageerror', e => errors.push(e.message));
        for (const language of ['en','ar']) {
            await page.goto(`http://localhost/newsuperprime-wordpress/?lang=${language}`, {waitUntil:'networkidle'});
            const scripts = await page.locator('script[src]').evaluateAll(scripts => scripts.map(s=>s.src));
            assert(scripts.some(src=>src.includes('/slick.min.js?')));
            assert(!scripts.some(src=>src.includes('/popper.min.js')));
            assert(!scripts.some(src=>src.includes('/bootstrap.min.js')));
            assert(scripts.some(src=>src.includes('/collapse.min.js')));
            const images = await page.locator('img[src]').evaluateAll(images=>images.map(i=>({src:i.src,w:i.getAttribute('width'),h:i.getAttribute('height'),decoding:i.decoding,loading:i.loading})));
            for (const image of images.filter(i=>i.src.includes('/assets/img/'))) {
                assert(Number(image.w)>0 && Number(image.h)>0, image.src+' dimensions');
                assert.equal(image.decoding,'async');
                if(image.src.includes('/logo/')) assert.notEqual(image.loading,'lazy');
            }
            assert.notEqual(await page.locator('.nsp-home-hero img').first().getAttribute('loading'),'lazy');
            assert(await page.locator('#clinox-about-3 img').evaluateAll(images=>images.every(i=>i.loading==='lazy')));
            await page.setViewportSize({width:390,height:844});
            assert(await page.evaluate(()=>document.documentElement.scrollWidth<=innerWidth));
            await page.setViewportSize({width:1440,height:1000});
        }
        const iconNames = fs.readFileSync('docs/performance-round2/icons.txt','utf8').trim().split('\n');
        const rendered = await page.evaluate(names=>names.map(name=>{
            const icon=document.createElement('i'); icon.className='fas '+name; document.body.append(icon);
            const content=getComputedStyle(icon,'::before').content; icon.remove();return content;
        }),iconNames);
        assert(rendered.every(content=>content && content!=='none' && content!=='normal'));
        const fontCSS=fs.readFileSync('assets/css/fontawesome-all.css','utf8');
        const fontFaces=fs.readFileSync('assets/css/fonts.css','utf8');
        const animations=fs.readFileSync('assets/css/animate.css','utf8');
        for (const name of ['fadeInUp','fadeInRight','fadeInDown','bounceInLeft','slideOutLeft','bounce','spin']) assert(animations.includes('@keyframes '+name));
        assert.equal((fontCSS.match(/@font-face/g)||[]).length,0);
        assert.equal((fontFaces.match(/font-family:\s*['\"]Font Awesome/g)||[]).length,4);
        assert((fontFaces.match(/font-display:\s*swap/g)||[]).length>=4);
        assert(!fontCSS.includes('fa-duotone') && !fontCSS.includes('.ttf'));
        assert.deepEqual(errors,[]);
        console.log('PASS: reduced icons, minified Slick, no Popper, native Collapse, intrinsic image sizes, async/lazy images, eager logos/hero, RTL and mobile.');
    } finally { await browser.close(); }
})().catch(e=>{console.error(e);process.exit(1)});
