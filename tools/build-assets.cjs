const fs = require('node:fs');
const path = require('node:path');
const postcss = require('postcss');
const cssnano = require('cssnano');
const {PurgeCSS} = require('purgecss');
const terser = require('terser');
const excluded = new Set(['node_modules', '.git', '.booking-build-cache', 'docs', 'tests']);
function walk(dir) { return fs.readdirSync(dir, {withFileTypes:true}).flatMap(entry => excluded.has(entry.name) ? [] : entry.isDirectory() ? walk(path.join(dir, entry.name)) : [path.join(dir, entry.name)]); }
const safelist = {
    standard: [/^(h[1-6]|blockquote|table|thead|tbody|tr|td|th|code|pre|dropdown-toggle)$/, /^(slick-|wow$|animated$|active$|show$|open$|is-|nsp-|rtl$|mfp-|modal|collaps|fade$)/, /^(wp-|wpcf7|screen-reader|menu-|current-|page-|post-|type-|attachment-|size-|logged-in$|admin-bar$|hentry$)/, /^(col-|row$|container|g-|gx-|gy-|d-|align-|justify-|order-|offset-)/, /^(sticky-on|search-active|mobile_menu|dropdown-btn|toggle-open|filtr-|custom-|jquery-ripples|appeared$|view-on$|tw-)/],
    deep: [/^(nsp-|slick-|mfp-|modal|collaps|wpcf7|wp-block-|mobile_menu|tw-)/],
    greedy: [/\[data-/, /\[aria-/, /\[hidden\]/, /:root/],
};
(async () => {
    const files = walk('.').filter(file => /\.(php|js)$/.test(file) && !/\.min\.js$/.test(file));
    const [purged] = await new PurgeCSS().purge({content:files, css:['assets/css/style.css'], safelist, keyframes:false, fontFace:false, variables:false, rejected:true});
    const result = await postcss([cssnano({preset:['default', {normalizeUrl:false}]})]).process(purged.css, {from:'assets/css/style.css', to:'assets/css/style.min.css'});
    fs.writeFileSync('assets/css/style.min.css', result.css);
    const report = {safelist:Object.fromEntries(Object.entries(safelist).map(([key, value]) => [key, value.map(String)])), css:{source:fs.statSync('assets/css/style.css').size, purged:Buffer.byteLength(purged.css), minified:Buffer.byteLength(result.css), removedSelectors:purged.rejected}, js:[]};
    for (const name of ['script', 'booking', 'service-preview', 'service-catalog', 'special-offers', 'home-booking', 'about-services', 'nsp-dropdowns', 'collapse', 'tracking-delay']) {
        const source = `assets/js/${name}.js`, dest = `assets/js/${name}.min.js`;
        const code = fs.readFileSync(source, 'utf8');
        const minified = await terser.minify(code, {compress:true, mangle:true, format:{comments:/@license|@preserve/}});
        fs.writeFileSync(dest, minified.code);
        report.js.push({source, dest, before:Buffer.byteLength(code), after:Buffer.byteLength(minified.code)});
    }
    const ripple = await terser.minify(fs.readFileSync('assets/js/jquery.ripples.source.js', 'utf8'), {format:{comments:/license/i}});
    fs.writeFileSync('assets/js/jquery.ripples.min.js', ripple.code);
    fs.mkdirSync('docs/performance-round4', {recursive:true});
    fs.writeFileSync('docs/performance-round4/build-report.json', JSON.stringify(report, null, 2));
    console.log(`CSS: ${report.css.source} -> ${report.css.minified} bytes; JS: ${report.js.reduce((sum, file) => sum+file.before, 0)} -> ${report.js.reduce((sum, file) => sum+file.after, 0)} bytes`);
})().catch(error => { console.error(error); process.exitCode = 1; });
