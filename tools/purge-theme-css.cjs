/* Generate candidates first; pass --apply only after reviewing the savings. */
const fs=require('fs'), path=require('path');
const {PurgeCSS}=require('purgecss');
const excluded=new Set(['node_modules','.git','.booking-build-cache','docs','tests']);
function walk(dir){return fs.readdirSync(dir,{withFileTypes:true}).flatMap(e=>excluded.has(e.name)?[]:e.isDirectory()?walk(path.join(dir,e.name)):[path.join(dir,e.name)])}
const safelist={
 standard:[/^(slick-|wow$|animated$|active$|show$|open$|is-|nsp-|rtl$|mfp-|modal-|collapse|fade$)/,/^(wp-|wpcf7|screen-reader|menu-|current-|page-|post-|type-|attachment-|size-|logged-in$|admin-bar$|hentry$)/,/^(col-|row$|container|g-|gx-|gy-|d-|align-|justify-|order-|offset-)/,/^(sticky-on|search-active|mobile_menu|dropdown-btn|filtr-|custom-|jquery-ripples|appeared$|view-on$)/],
 deep:[/^(nsp-|slick-|mfp-|modal-|wpcf7|wp-block-|mobile_menu)/],
 greedy:[/\[data-/,/\[aria-/,/\[hidden\]/,/:root/],
};
(async()=>{
 const files=walk('.').filter(f=>/\.(php|js)$/.test(f));
 const snapshots=fs.existsSync('.booking-build-cache/round3-html')?fs.readdirSync('.booking-build-cache/round3-html').map(f=>'.booking-build-cache/round3-html/'+f):[];
 const input=['assets/css/bootstrap.min.css','assets/css/style.css'];
 const results=await new PurgeCSS().purge({content:[...files,...snapshots],css:input,safelist,keyframes:false,fontFace:false,variables:false,rejected:true});
 const report=[];
 for(const result of results){result.css=result.css.replace(/[ \t]+$/gm,'');const dest='.booking-build-cache/round3-'+path.basename(result.file);fs.writeFileSync(dest,result.css);report.push({file:result.file,before:fs.statSync(result.file).size,after:Buffer.byteLength(result.css),rejected:result.rejected.length});if(process.argv.includes('--apply'))fs.copyFileSync(dest,result.file);}
 fs.mkdirSync('docs/performance-round3',{recursive:true});fs.writeFileSync('docs/performance-round3/css-purge-report.json',JSON.stringify({safelist:Object.fromEntries(Object.entries(safelist).map(([k,v])=>[k,v.map(String)])),results:report},null,2));console.log(JSON.stringify(report,null,2));
})().catch(e=>{console.error(e);process.exit(1)});
