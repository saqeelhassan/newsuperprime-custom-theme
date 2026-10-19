(() => {
    'use strict';
    function init() {
    const modal = document.querySelector('#nsp-special-offers');
    if (!modal) return;
    const visitorKey = modal.dataset.visitorKey || 'nsp_offers_seen';
    function hasSeenOffers() {
        try { if (localStorage.getItem(visitorKey) === '1') return true; } catch { /* Check the cookie fallback below. */ }
        return document.cookie.split(';').some(cookie => cookie.trim() === `${visitorKey}=1`);
    }
    function rememberVisit() {
        try { localStorage.setItem(visitorKey, '1'); }
        catch {
            document.cookie = `${visitorKey}=1; Max-Age=31536000; Path=/; SameSite=Lax${location.protocol === 'https:' ? '; Secure' : ''}`;
        }
    }
    const slides = [...modal.querySelectorAll('[data-offer-slide]')];
    const dots = [...modal.querySelectorAll('[data-offer-dot]')];
    let index = 0;
    let attempted = false;
    let handingOff = false;
    let previousFocus;
    function showSlide(next) {
        index = (next + slides.length) % slides.length;
        slides.forEach((slide, i) => { slide.hidden = i !== index; });
        dots.forEach((dot, i) => dot.setAttribute('aria-pressed', String(i === index)));
        modal.querySelector('[data-offers-counter]').textContent = `${index + 1} / ${slides.length}`;
        modal.querySelector('.nsp-offers-body').scrollTop = 0;
    }
    function showOffers() {
        if (attempted || hasSeenOffers() || !modal.isConnected || document.visibilityState === 'hidden') return;
        attempted = true;
        // A visitor already choosing a service should not be interrupted.
        if (document.querySelector('dialog[open]')) return;
        previousFocus = document.activeElement;
        modal.showModal();
        rememberVisit();
        document.documentElement.classList.add('nsp-offers-open');
        modal.querySelector('h2').focus({ preventScroll: true });
    }
    modal.querySelector('[data-offers-close]').addEventListener('click', () => modal.close());
    modal.querySelector('[data-offers-prev]').addEventListener('click', () => showSlide(index - 1));
    modal.querySelector('[data-offers-next]').addEventListener('click', () => showSlide(index + 1));
    dots.forEach(dot => dot.addEventListener('click', () => showSlide(Number(dot.dataset.offerDot))));
    modal.addEventListener('keydown', event => {
        if (!['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
        event.preventDefault();
        const direction = document.documentElement.dir === 'rtl' ? -1 : 1;
        showSlide(index + (event.key === 'ArrowRight' ? direction : -direction));
    });
    let touchStart;
    modal.querySelector('.nsp-offers-body').addEventListener('touchstart', event => { touchStart = event.changedTouches[0].clientX; }, { passive: true });
    modal.querySelector('.nsp-offers-body').addEventListener('touchend', event => {
        if (touchStart === undefined) return;
        const distance = event.changedTouches[0].clientX - touchStart;
        if (Math.abs(distance) > 60) showSlide(index + (distance < 0 ? 1 : -1) * (document.documentElement.dir === 'rtl' ? -1 : 1));
        touchStart = undefined;
    }, { passive: true });
    modal.addEventListener('nsp:handoff', () => { handingOff = true; });
    modal.addEventListener('close', () => {
        attempted = true;
        document.documentElement.classList.remove('nsp-offers-open');
        if (!handingOff && previousFocus?.isConnected) previousFocus.focus({ preventScroll: true });
    });
    // Remember the first display across pages and future browser visits.
    if (document.readyState === 'complete') setTimeout(showOffers, 1200);
    else window.addEventListener('load', () => setTimeout(showOffers, 1200), { once: true });
    setTimeout(showOffers, 2500);
    document.addEventListener('visibilitychange', () => { if (document.visibilityState === 'visible') showOffers(); });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, { once: true });
    else init();
})();
