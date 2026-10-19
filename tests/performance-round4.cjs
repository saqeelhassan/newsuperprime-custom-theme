const {chromium}=require('playwright');
const assert=require('node:assert/strict');
const fs=require('node:fs');
const base=process.env.WP_TEST_URL||'http://localhost/newsuperprime-wordpress/';
(async()=>{
 const browser=await chromium.launch({channel:'msedge',args:['--enable-unsafe-swiftshader']});
 try{
  const scenarios=[{name:'mobile',width:390},{name:'tablet',width:991},{name:'coarse',width:1440,touch:true},{name:'four cores',width:1440,cores:4},{name:'save data',width:1440,saveData:true},{name:'reduced motion',width:1440,reduce:true}];
  for(const scenario of scenarios){
   const context=await browser.newContext({viewport:{width:scenario.width,height:900},hasTouch:!!scenario.touch,reducedMotion:scenario.reduce?'reduce':'no-preference'});
   const page=await context.newPage();await require('./hide-offers.cjs')(page);
   await page.addInitScript(({cores,saveData})=>{
    Object.defineProperty(navigator,'hardwareConcurrency',{get:()=>cores||8});
    Object.defineProperty(navigator,'connection',{get:()=>({saveData:!!saveData,addEventListener(){}})});
   },scenario);
   await page.goto(base+'?lang=en',{waitUntil:'networkidle'});
   await page.waitForTimeout(600);
   assert.equal(await page.locator('#clinox-banner-3 canvas').count(),0,scenario.name);
   assert.equal(await page.locator('script[src*="jquery.ripples"]').count(),0,scenario.name+' must not download/probe WebGL');
   await page.locator('[data-hero-dot="1"]').click();
   assert(await page.locator('[data-hero-slide]').nth(1).isVisible());
   await context.close();
  }
  const context=await browser.newContext({viewport:{width:1440,height:1000},reducedMotion:'no-preference'});
  const page=await context.newPage();await require('./hide-offers.cjs')(page);
  await page.addInitScript(()=>Object.defineProperty(navigator,'hardwareConcurrency',{get:()=>8}));
  await page.goto(base+'?lang=en',{waitUntil:'networkidle'});
  await page.waitForFunction(()=>Boolean(jQuery('#clinox-banner-3').data('ripples')));
  await page.evaluate(()=>scrollTo(0,2000));
  await page.waitForFunction(()=>jQuery('#clinox-banner-3').data('ripples').visible===false);
  assert.equal(await page.evaluate(()=>jQuery('#clinox-banner-3').data('ripples').running),false);
  await page.evaluate(()=>scrollTo(0,0));
  await page.waitForFunction(()=>jQuery('#clinox-banner-3').data('ripples').running);
  await page.evaluate(()=>{Object.defineProperty(document,'hidden',{get:()=>true,configurable:true});document.dispatchEvent(new Event('visibilitychange'));});
  assert.equal(await page.evaluate(()=>jQuery('#clinox-banner-3').data('ripples').visible),false);
  await page.evaluate(()=>{Object.defineProperty(document,'hidden',{get:()=>false,configurable:true});document.dispatchEvent(new Event('visibilitychange'));});
  assert.equal(await page.evaluate(()=>jQuery('#clinox-banner-3').data('ripples').running),true);
  await page.setViewportSize({width:390,height:844});
  await page.waitForTimeout(250);
  await page.locator('[data-hero-dot="2"]').click();
  assert.equal(await page.locator('[data-hero-slide]').nth(2).locator('img').evaluate(el=>getComputedStyle(el).visibility),'visible');
  assert(await page.locator('#clinox-banner-3').evaluate(el=>el.style.backgroundImage.includes(el.dataset.background)));
  const inline=await page.locator('#nsp-critical-css').textContent();
  assert(Buffer.byteLength(inline)<14*1024);
  assert(!inline.includes('@font-face')&&!/data:.*font/.test(inline));
  assert(await page.locator('link[href*="style.min.css"]').count());
  assert(await page.locator('img[srcset*="ab1-465.jpg"]').count());
  await context.close();
  const tracking=await browser.newContext();let loads=0;
  await tracking.route('https://www.googletagmanager.com/**',route=>{loads++;return route.fulfill({contentType:'application/javascript',body:''});});
  const tracked=await tracking.newPage();await require('./hide-offers.cjs')(tracked);
  await tracked.goto(base+'?lang=en',{waitUntil:'domcontentloaded'});
   await tracked.evaluate(()=>{
    const tag=document.createElement('script');tag.type='text/plain';
    tag.dataset.nspTrackingSrc='https://www.googletagmanager.com/gtag/js?id=GT-EXAMPLE';
    document.head.append(tag);gtag('config','GT-EXAMPLE');
   });
  await tracked.waitForTimeout(500);assert.equal(loads,0);
   await tracked.keyboard.press('Tab');await tracked.waitForTimeout(200);assert.equal(loads,2);
   await tracked.keyboard.press('Tab');await tracked.waitForTimeout(200);assert.equal(loads,2);
   await tracked.reload({waitUntil:'domcontentloaded'});await tracked.waitForTimeout(4300);assert.equal(loads,3);
  assert(!fs.readFileSync('assets/css/fonts.css','utf8').includes('data:'));
  await tracking.close();
  console.log('PASS: all six ripple gates; lazy desktop WebGL; offscreen/hidden pause and resume; resized static slides; inline CSS budget; minified CSS and responsive image; GTM interaction/timer gate and no duplicate load.');
 }finally{await browser.close()}
})().catch(error=>{console.error(error);process.exitCode=1});
