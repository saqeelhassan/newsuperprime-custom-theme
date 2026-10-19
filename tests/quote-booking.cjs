const {chromium}=require('playwright');
const assert=require('node:assert/strict');
const base=process.env.WP_TEST_URL||'http://localhost/newsuperprime-wordpress/';
(async()=>{
 const browser=await chromium.launch({channel:'msedge'});
 try{
  const page=await browser.newPage({reducedMotion:'reduce'});
  await require('./hide-offers.cjs')(page);
  const errors=[];page.on('pageerror',error=>errors.push(error.message));
  for(const lang of ['en','ar'])for(const width of [375,1440]){
   await page.setViewportSize({width,height:900});
   await page.goto(base+'services/?lang='+lang,{waitUntil:'networkidle'});
   await page.evaluate(()=>{
    window.quoteRequests=[];window.open=url=>window.quoteRequests.push(url);
    Object.defineProperty(navigator,'geolocation',{configurable:true,value:{getCurrentPosition:success=>success({coords:{latitude:26.3,longitude:50.1}})}});
   });
   const trigger=page.locator('.nsp-service-card [data-packages="[]"]').first();
   const service=await trigger.getAttribute('data-service-title');
   await trigger.click();
   assert.equal(await page.locator('[data-preview-price]').textContent(),'');
   await page.locator('[data-preview-quote]').click();
   const wizard=page.locator('#nsp-booking'),next=wizard.locator('[data-next]');
   assert(await wizard.evaluate(el=>el.open));
   assert.equal(await wizard.locator('[name=package]').count(),0);
   await next.click();
   await next.click();assert(await wizard.locator('[data-error]').isVisible());
   await wizard.locator('[name=city][value=Khobar]').check();
   if(width===1440)await wizard.locator('[data-gps]').click();
   else{
    await wizard.locator('[name=street]').fill('45 Customer Street');
    await wizard.locator('[name=area]').fill('Customer Neighborhood');
   }
   await next.click();
   await wizard.locator('[name=date]').fill('2099-12-31');
   const time=wizard.locator('[name=time]').first();await time.check();const slot=await time.inputValue();
   await next.click();
   await wizard.locator('[name=fullName]').fill('Quote Customer');
   await wizard.locator('[name=mobile]').fill('+966500000000');
   await wizard.locator('[name=instructions]').fill('Please call before arrival');
   await next.click();
   assert.equal(await wizard.locator('[data-pricing]').isVisible(),false);
   for(const key of ['regular','discount','total'])assert.equal(await wizard.locator(`[data-${key}]`).textContent(),'');
   await next.click();
   const requests=await page.evaluate(()=>window.quoteRequests);assert.equal(requests.length,1);
   const url=new URL(requests[0]);assert.equal(url.searchParams.get('phone'),'966559357772');
   const message=url.searchParams.get('text');
   for(const value of [service,'Quote Customer','+966500000000','Khobar','2099-12-31',slot,'Please call before arrival','WhatsApp'])assert(message.includes(value),value);
   for(const value of width===1440?['26.3','50.1','https://maps.google.com/?q=26.3,50.1']:['45 Customer Street','Customer Neighborhood'])assert(message.includes(value),value);
   assert(new RegExp('^'+(lang==='ar'?'السعر':'Price')+': *$','m').test(message));
   assert(!/SAR|NaN|undefined|Regular price|Final price|10%/.test(message));
   await page.keyboard.press('Escape');
   await page.waitForFunction(()=>!document.documentElement.classList.contains('nsp-booking-open'));
   // Reopening a priced service must restore package selection and known prices.
   await page.locator('.nsp-service-card [data-nsp-booking]:not([data-packages="[]"])').first().click();
   assert(await page.locator('[data-preview-continue]').isVisible());
   assert(await page.locator('[data-preview-price]').isVisible());
   await page.locator('[data-preview-continue]').click();
   assert(await wizard.locator('[name=package]').count()>0);
   assert.equal(await wizard.locator('[name=package]:checked').count(),1);
   await next.click();assert(await wizard.locator('[data-step="2"]').isVisible());
   await page.keyboard.press('Escape');
  }
  assert.deepEqual(errors,[]);
  console.log('PASS: quote preview to all five steps; EN/AR at mobile/desktop; typed address and GPS/map; validation; blank pricing; complete WhatsApp payload; reset to priced service.');
 }finally{await browser.close()}
})().catch(error=>{console.error(error);process.exitCode=1});
