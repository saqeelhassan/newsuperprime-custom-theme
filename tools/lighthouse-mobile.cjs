const fs=require('node:fs');
const path=require('node:path');
(async()=>{
 const lighthouse=(await import('lighthouse')).default;
 const {launch}=await import('chrome-launcher');
 const profile=path.resolve('.booking-build-cache/lighthouse-'+Date.now());
 fs.mkdirSync(profile,{recursive:true});
 const chrome=await launch({chromePath:'C:/Program Files/Google/Chrome/Application/chrome.exe',userDataDir:profile,chromeFlags:['--headless=new','--disable-extensions','--no-first-run','--disable-default-apps']});
 try{
  const url=process.env.WP_TEST_URL||'http://localhost/newsuperprime-wordpress/?lang=en';
  const result=await lighthouse(url,{port:chrome.port,output:['json','html'],onlyCategories:['performance','accessibility'],formFactor:'mobile',throttlingMethod:'simulate',logLevel:'error'});
  fs.mkdirSync('docs/performance-round4',{recursive:true});
  fs.writeFileSync('docs/performance-round4/lighthouse-mobile.json',result.report[0]);
  fs.writeFileSync('docs/performance-round4/lighthouse-mobile.html',result.report[1]);
  const lhr=result.lhr;
  const metrics={url:lhr.finalDisplayedUrl,chrome:lhr.environment.hostUserAgent,performance:lhr.categories.performance.score*100,accessibility:lhr.categories.accessibility.score*100,TBT:lhr.audits['total-blocking-time'].numericValue,LCP:lhr.audits['largest-contentful-paint'].numericValue,CLS:lhr.audits['cumulative-layout-shift'].numericValue};
  fs.writeFileSync('docs/performance-round4/lighthouse-metrics.json',JSON.stringify(metrics,null,2));console.log(metrics);
 }finally{await chrome.kill()}
})().catch(error=>{console.error(error);process.exitCode=1});
