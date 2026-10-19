/* Keep analytics events queued while delaying third-party execution. */
(() => {
    const layer = window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function () { layer.push(arguments); };
    const events = ['scroll', 'pointerdown', 'keydown', 'touchstart'];
    const loaded = new Set();
    let started = false;
    const load = (src, id) => {
        const url = new URL(src, location.href);
        const key = url.origin + url.pathname + '?id=' + url.searchParams.get('id');
        if (loaded.has(key) || [...document.scripts].some(script => script.src && new URL(script.src, location.href).href === url.href)) return;
        loaded.add(key);
        const script = document.createElement('script');
        script.src = url.href;
        script.async = true;
        if (id) script.id = id;
        document.head.append(script);
    };
    const flush = () => {
        if (!started) return;
        document.querySelectorAll('script[data-nsp-tracking-src]').forEach(script => {
            load(script.dataset.nspTrackingSrc, script.id + '-delayed');
            script.remove();
        });
    };
    const start = () => {
        if (started) return;
        started = true;
        events.forEach(event => window.removeEventListener(event, start));
        clearTimeout(timer);
        layer.push({'gtm.start': Date.now(), event: 'gtm.js'});
        load('https://www.googletagmanager.com/gtm.js?id=GTM-5Z27DP4H', 'google-tag-manager-delayed');
        flush();
    };
    const timer = setTimeout(start, 4000);
    events.forEach(event => window.addEventListener(event, start, {once:true, passive:true}));
    new MutationObserver(flush).observe(document.head, {childList:true});
})();
