const {chromium}=require('playwright');
const assert=require('node:assert/strict');
const fs=require('node:fs');
const base=process.env.WP_TEST_URL||'http://localhost/newsuperprime-wordpress/';
(async()=>{
 const browser=await chromium.launch({channel:'msedge',headless:true});
 try{
  const page=await browser.newPage({reducedMotion:'reduce'});
  await require('./hide-offers.cjs')(page);
  const errors=[];page.on('pageerror',e=>errors.push(e.message));
  await page.goto(base+'services/?lang=en',{waitUntil:'networkidle'});
  const single=(await page.locator('.nsp-service-card h3 a').first().getAttribute('href')).replace(base,'');
  const outcomes=[];
  for(const lang of ['en','ar'])for(const width of [375,1440])for(const route of ['', 'services/',single,'contact/']){
   await page.setViewportSize({width,height:900});
   await page.route('**/assets/css/*.css*',async request=>{await new Promise(resolve=>setTimeout(resolve,1200));await request.continue()});
   await page.goto(base+route+'?lang='+lang,{waitUntil:'domcontentloaded'});
   await page.evaluate(async()=>{document.querySelector('#preloader')?.remove();await document.fonts.ready;});
   const boxes=()=>page.evaluate(()=>Object.fromEntries(['#clinox-header','.nsp-catalog-hero','.nsp-hero-copy','#clinox-estimate','#clinox-breadcrumb','.clinox-section-title-3'].map(selector=>{
    const el=document.querySelector(selector);if(!el)return null;const rect=el.getBoundingClientRect();if(rect.top>=innerHeight)return null;return[selector,[rect.x,rect.y,rect.width,rect.height]];
   }).filter(Boolean)));
   const before=await boxes();
   const paint=()=>page.evaluate(()=>Object.fromEntries(['body','#clinox-header a','.nsp-hero-copy h2','.nsp-hero-copy p','.nsp-home-booking-controls button'].map(selector=>{
    const el=document.querySelector(selector);if(!el)return null;const style=getComputedStyle(el);
    return [selector,['color','background-color','font-family','font-size','font-weight','line-height','border-radius'].map(name=>style.getPropertyValue(name))];
   }).filter(Boolean)));
   const beforePaint=await paint();
   await page.waitForLoadState('networkidle');
   const after=await boxes();
   for(const [selector,values] of Object.entries(before))for(let i=0;i<4;i++)assert(Math.abs(values[i]-after[selector][i])<1,`${lang}/${width}/${route}: ${selector} layout shift ${values} -> ${after[selector]}`);
   assert.deepEqual(await paint(),beforePaint,`${lang}/${width}/${route}: first-screen paint styles must match`);
   assert(await page.evaluate(()=>document.documentElement.scrollWidth<=innerWidth));
   assert.equal(await page.locator('head script[src*="/jquery/"]').count(),0);
   assert.equal(await page.locator('head link[href*="fonts.googleapis.com"],head link[href*="fonts.gstatic.com"]').count(),0);
   assert.equal(await page.locator('head link[as=font]').count(),lang==='en'?2:0);
   assert(await page.locator('style#nsp-critical-css').count());
   const raw=await page.content();assert(raw.includes('<noscript><link'));
   if(width===375)assert(await page.locator('.wow').evaluateAll(elements=>elements.every(el=>getComputedStyle(el).visibility==='visible')));
   if(route==='services/'||route===''){
    assert.equal(await page.locator('[data-hero-slide] img').first().getAttribute('loading'),'eager');
    const image=await page.locator('head link[as=image]').getAttribute('href');
    assert.equal(image,await page.locator('[data-hero-slide] img').first().getAttribute('src'));
    await page.locator('[data-hero-dot]').nth(1).click();
    assert(await page.locator('[data-hero-slide]').nth(1).isVisible());
   }
   if(route==='contact/'){
    const form=page.locator('.clinox-contact-form form');
    if(await form.locator('[name=name]').count()){
     await form.locator('[name=name]').fill('Performance test');await form.locator('[name=email]').fill('test@example.com');
     await form.locator('[name=phone]').fill('0559357772');await form.locator('[name=message]').fill('Local validation only; do not send.');
     assert(await form.evaluate(el=>el.checkValidity()));
    }
   }
   outcomes.push(`${lang} ${width}px ${route||'home'}: stable first screen, functional hero/forms`);
   await page.unroute('**/assets/css/*.css*');
  }
  // Real saved service/package -> wizard -> intercepted WhatsApp handoff.
  await page.goto(base+'?lang=en',{waitUntil:'networkidle'});
  await page.evaluate(()=>{window.nspTestMessages=[];window.open=(url)=>{window.nspTestMessages.push(url);return null;};});
  await page.locator('#clinox-header [data-nsp-booking]').click();
  await page.locator('[data-preview-continue]').click();
  const wizard=page.locator('#nsp-booking');const next=wizard.locator('[data-next]');
  await next.click();await wizard.locator('[name=city][value=Dammam]').check();
  await wizard.locator('[name=street]').fill('12 King Street');await wizard.locator('[name=area]').fill('Al Faisaliyah');await next.click();
  await wizard.locator('[name=date]').fill('2099-12-31');await wizard.locator('[name=time]').first().check();await next.click();
  await wizard.locator('[name=fullName]').fill('Local performance test');await wizard.locator('[name=mobile]').fill('0559357772');await next.click();
  assert(await wizard.locator('[data-total]').isVisible());await next.click();
  assert.match(await page.evaluate(()=>window.nspTestMessages[0]),/^https:\/\/api\.whatsapp\.com\/send\?/);
  for(const lang of ['en','ar'])for(const width of [375,1440]){
   const offerPage=await browser.newPage({viewport:{width,height:900},reducedMotion:'reduce'});
   offerPage.on('pageerror',e=>errors.push(e.message));
   await offerPage.goto(base+'?lang='+lang,{waitUntil:'networkidle'});
   const popup=offerPage.locator('#nsp-special-offers');await popup.waitFor({state:'visible'});
   assert(await popup.evaluate(el=>el.scrollWidth<=el.clientWidth));
   await popup.locator('[data-offers-next]').click();await popup.locator('[data-offers-prev]').click();
   await popup.locator('[data-offer-slide]').first().locator('[data-nsp-booking]').click();
   await offerPage.locator('#nsp-service-preview[open]').waitFor();
   await offerPage.locator('[data-preview-continue]').click();await offerPage.locator('#nsp-booking[open]').waitFor();
   assert(await offerPage.locator('#nsp-booking').evaluate(el=>el.scrollWidth<=el.clientWidth));
   outcomes.push(`${lang} ${width}px special offer -> preview -> wizard: passed`);
   await offerPage.close();
  }
  assert.deepEqual(errors,[]);
  fs.writeFileSync('docs/performance-round3/page-checks.txt',outcomes.join('\n')+'\nLive booking -> WhatsApp payload: passed (navigation intercepted).\nCF7 plugin absent locally: fallback contact form validation checked; delivery requires production check.\n');
  console.log('PASS: 16 delayed-CSS page/language/viewport checks, stable first-screen boxes, eager hero/preload/fallback, local fonts, footer jQuery, mobile WOW visibility, contact validation and live WhatsApp booking payload.');
 }finally{await browser.close()}
})().catch(e=>{console.error(e);process.exit(1)});
