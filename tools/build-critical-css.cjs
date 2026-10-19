/* Build first-screen CSS from actual pages, languages and responsive widths. */
const {chromium}=require('playwright');
const fs=require('fs');
const postcss=require('postcss');
const base=process.env.WP_TEST_URL||'http://localhost/newsuperprime-wordpress/';
(async()=>{
 const browser=await chromium.launch({channel:'msedge',headless:true});
 try {
  const page=await browser.newPage({reducedMotion:'reduce'});
  await require('../tests/hide-offers.cjs')(page);
  await page.route('**/*',async route=>{
   if(route.request().resourceType()!=='document')return route.continue();
   const response=await route.fetch();let body=await response.text();
   body=body.replace(/<style id="nsp-critical-css">[\s\S]*?<\/style>/g,'').replace(/media="print"/g,'media="all"');
   await route.fulfill({response,body});
  });
  await page.goto(base+'services/?lang=en');
  const single=await page.locator('.nsp-service-card h3 a').first().getAttribute('href');
  const routes=['', 'services/','contact/','about/','faq/','projects/',single.replace(base,'')];
  const collected=new Map();
  const layouts={};
  for(const lang of ['en','ar'])for(const width of [375,768,1024,1440])for(const route of routes){
   await page.setViewportSize({width,height:900});
   await page.goto(base+route+'?lang='+lang,{waitUntil:'domcontentloaded'});
   await page.evaluate(async()=>{await document.fonts.ready;document.querySelector('#preloader')?.remove();});
   const result=await page.evaluate(()=>{
    const output=[];
    const visit=(rules,url,indices=[],wrappers=[])=>{
     const rewrite=s=>s.replace(/url\(["']?([^"')]+)["']?\)/g,(all,value)=>value.startsWith('data:')?all:`url("${new URL(value,url).href}")`);
     for(let index=0;index<rules.length;index++){
      const rule=rules[index], rulePath=[...indices,index];
      const emit=text=>output.push({url,path:rulePath,css:wrappers.reduceRight((inner,head)=>head+'{'+inner+'}',text)});
      if(rule.type===CSSRule.FONT_FACE_RULE){emit(rewrite(rule.cssText));continue;}
      if(rule.type===CSSRule.KEYFRAMES_RULE){emit(rule.cssText);continue;}
      if(rule.type!==CSSRule.STYLE_RULE&&rule.cssRules){
       if(rule.type===CSSRule.MEDIA_RULE&&!matchMedia(rule.conditionText).matches)continue;
       visit(rule.cssRules,url,rulePath,[...wrappers,rule.cssText.slice(0,rule.cssText.indexOf('{'))]);continue;
      }
      if(!rule.selectorText)continue;
      let keep=/:root|^html|^body|#nsp-booking|#nsp-service-preview|#nsp-special-offers|\.nsp-preview|\.nsp-offer|\.nsp-booking|mobile_menu|preloader|scrollup|search-popup|sticky-on|\[hidden\]/.test(rule.selectorText);
      if(!keep)try{keep=[...document.querySelectorAll(rule.selectorText)].some(el=>{
       if(el.closest('#clinox-header'))return true;
       const rect=el.getBoundingClientRect();return rect.width>0&&rect.height>0&&rect.top<innerHeight&&rect.bottom>0;
      });}catch{}
      if(keep)emit(rewrite(rule.cssText));
     }
    };
    for(const sheet of document.styleSheets)try{if(sheet.href&&sheet.href.includes('/themes/'))visit(sheet.cssRules,sheet.href);}catch{}
    const boxes={};for(const selector of ['#clinox-header','.nsp-catalog-hero','.nsp-hero-copy','#clinox-estimate','#nsp-quick-service','.nsp-catalog-shell','.nsp-section-heading','.clinox-breadcrumb-section']){
     const el=document.querySelector(selector);if(el){const r=el.getBoundingClientRect();boxes[selector]={x:r.x,y:r.y,width:r.width,height:r.height};}
    }
    return {css:output,boxes};
   });
   const view=(route===''?'home':route==='services/'?'catalog':'inner')+'-'+lang;
   for(const rule of result.css){const key=rule.url+'|'+rule.path.join('.');if(!collected.has(key))collected.set(key,{...rule,views:new Set()});collected.get(key).views.add(view);}
   layouts[`${lang}|${width}|${route}`]=result.boxes;
  }
  const order=['fonts.css','bootstrap.min.css','fontawesome-all.css','animate.css','video.min.css','slick.css','slick-theme.css','magnific-popup.css','reset.css','style.css','rtl.css','booking.css','service-preview.css','service-catalog.css','special-offers.css','home.css'];
  const sorted=[...collected.values()].sort((a,b)=>{
   const rank=url=>order.indexOf(url.split('/').pop().split('?')[0]);
   if(rank(a.url)!==rank(b.url))return rank(a.url)-rank(b.url);
   for(let i=0;i<Math.max(a.path.length,b.path.length);i++){if(a.path[i]!==b.path[i])return (a.path[i]??-1)-(b.path[i]??-1)}return 0;
  });
  const themeURI=(await page.locator('#nsp-main-css').getAttribute('href')).split('/assets/css/')[0];
  for(const view of ['home-en','home-ar','catalog-en','catalog-ar','inner-en','inner-ar']){
   const css=sorted.filter(r=>r.views.has(view)).map(r=>r.css.replaceAll(themeURI,'__NSP_THEME_URI__')).join('\n')+'\n';
   const root=postcss.parse(css);root.walkComments(n=>n.remove());root.walk(n=>{n.raws.before='';n.raws.after='';if(n.type==='decl')n.raws.between=':';else if(n.type==='rule'||n.type==='atrule')n.raws.between='';});root.raws.after='';
   fs.writeFileSync('assets/css/critical-'+view+'.css',root.toString());console.log(view,Buffer.byteLength(root.toString()),'bytes');
  }
  fs.writeFileSync('.booking-build-cache/round3-layouts-after.json',JSON.stringify(layouts));
  console.log('Critical CSS built from',Object.keys(layouts).length,'page/viewport/language samples.');
 }finally{await browser.close()}
})().catch(e=>{console.error(e);process.exit(1)});
