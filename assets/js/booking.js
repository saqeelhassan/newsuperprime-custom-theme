/* New Super Prime — client-only booking wizard. No form data is persisted. */
(() => {
    'use strict';
    const modal = document.querySelector('#nsp-booking');
    if (!modal) return;
    const form = modal.querySelector('form');
    const find = selector => modal.querySelector(selector);
    const titles = ['Select service & package', 'Service location', 'Preferred schedule', 'Contact details', 'Review booking request'];
    const state = {};
    let opener;
    let gpsRequest = 0;
    let previousOverflowClass = false;
    const money = cents => new Intl.NumberFormat('en-SA', { style: 'currency', currency: 'SAR' }).format(cents / 100);
    const today = () => new Intl.DateTimeFormat('en-CA', { timeZone: 'Asia/Riyadh', year: 'numeric', month: '2-digit', day: '2-digit' }).formatToParts(new Date()).reduce((parts, part) => ({ ...parts, [part.type]: part.value }), {});
    function dateToday() {
        const parts = today();
        return `${parts.year}-${parts.month}-${parts.day}`;
    }
    function reference() {
        const bytes = new Uint8Array(4);
        crypto.getRandomValues(bytes);
        return `NSP-${dateToday().replaceAll('-', '')}-${Array.from(bytes, byte => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'[byte % 36]).join('')}`;
    }
    function error(message = '', selector) {
        find('[data-error]').textContent = message;
        find('[data-error]').hidden = !message;
        if (selector) find(selector)?.focus();
        return !message;
    }
    function selected(name) {
        return form.elements[name]?.value || '';
    }
    function capture() {
        for (const key of ['city', 'street', 'area', 'date', 'time', 'fullName', 'mobile', 'contactMethod', 'instructions']) {
            state[key] = selected(key).trim();
        }
    }
    function validate(step) {
        capture();
        if (step === 1 && !state.quote && !state.package) return error('Choose a package to continue.', 'input[name="package"]');
        if (step === 2) {
            if (!state.city) return error('Select your city.', 'input[name="city"]');
            if (!state.gps && !state.street) return error('Capture your GPS location or enter your street address.', '[name="street"]');
            if (!state.gps && !state.area) return error('Enter your area or neighborhood.', '[name="area"]');
        }
        if (step === 3) {
            const dateInput = form.elements.date;
            dateInput.min = dateToday();
            if (!state.date || !dateInput.validity.valid || state.date < dateToday()) return error('Choose today or a future date.', '[name="date"]');
            if (!state.time) return error('Select a preferred time slot.', 'input[name="time"]');
        }
        if (step === 4) {
            if (state.fullName.length < 2) return error('Enter your full name.', '[name="fullName"]');
            if (!/^\+?[\d\s()-]+$/.test(state.mobile) || !/^\d{8,15}$/.test(state.mobile.replace(/\D/g, ''))) return error('Enter a valid mobile number with 8–15 digits.', '[name="mobile"]');
            if (!['WhatsApp', 'Phone Call'].includes(state.contactMethod)) return error('Choose a contact method.', 'input[name="contactMethod"]');
        }
        return error();
    }
    function totals() {
        if (state.quote) return null;
        const regular = Math.round(state.package.package_price * 100);
        const discount = Math.round(regular * 0.10);
        return { regular, discount, final: regular - discount };
    }
    function locationText() {
        return state.gps ? `GPS: ${state.gps.latitude}, ${state.gps.longitude}\nhttps://maps.google.com/?q=${state.gps.latitude},${state.gps.longitude}` : `${state.street}, ${state.area}`;
    }
    function summaryRows() {
        return [
            ['Service', state.service.title], ...(state.quote ? [] : [['Package', state.package.package_name],
            ['Package description', state.package.package_description || '—'], ['Package perk', state.package.package_perk || '—']]),
            ['City', state.city], ['Location', locationText()], ['Date', state.date],
            ['Time (Saudi Arabia)', state.time], ['Full name', state.fullName], ['Mobile', state.mobile],
            ['Preferred contact', state.contactMethod], ['Special instructions', state.instructions || 'None'],
        ];
    }
    function renderReview() {
        if (!state.reference) state.reference = reference();
        find('[data-reference]').textContent = state.reference;
        const list = find('[data-summary]');
        list.replaceChildren();
        summaryRows().forEach(([label, value]) => {
            const row = document.createElement('div');
            row.className = 'tw-grid tw-gap-1 sm:tw-grid-cols-2 tw-border-0 tw-border-b tw-border-solid tw-border-slate-200 tw-pb-3';
            const term = document.createElement('dt');
            term.className = 'tw-text-sm tw-text-slate-500';
            term.textContent = label;
            const description = document.createElement('dd');
            description.className = 'tw-m-0 tw-whitespace-pre-wrap tw-break-words tw-font-medium';
            description.textContent = value;
            row.append(term, description);
            list.append(row);
        });
        const prices = totals();
        find('[data-pricing]').hidden = state.quote;
        find('[data-regular]').textContent = prices ? money(prices.regular) : '';
        find('[data-discount]').textContent = prices ? `−${money(prices.discount)}` : '';
        find('[data-total]').textContent = prices ? money(prices.final) : '';
    }
    function goTo(step, focus = true) {
        state.step = Math.max(1, Math.min(5, step));
        error();
        modal.querySelectorAll('[data-step]').forEach(panel => { panel.hidden = Number(panel.dataset.step) !== state.step; });
        find('[data-back]').hidden = state.step === 1;
        find('[data-next]').textContent = state.step === 5 ? 'Send Booking Request on WhatsApp' : 'Continue →';
        find('[data-next]').disabled = state.step === 1 && !state.quote && !state.packages.length;
        find('[data-step-count]').textContent = `STEP ${state.step} OF 5`;
        find('#nsp-booking-title').textContent = state.step === 1 && state.quote ? modal.dataset.quoteServiceLabel : titles[state.step - 1];
        modal.querySelectorAll('[data-dot]').forEach((dot, index) => {
            dot.classList.toggle('tw-bg-prime', index < state.step);
            dot.classList.toggle('tw-bg-slate-200', index >= state.step);
            if (index === state.step - 1) dot.setAttribute('aria-current', 'step');
            else dot.removeAttribute('aria-current');
        });
        if (state.step === 5) renderReview();
        find('[data-body]').scrollTop = 0;
        if (focus) find('#nsp-booking-title').focus();
    }
    function renderPackages() {
        const list = find('[data-packages]');
        list.replaceChildren();
        state.packages.forEach((pkg, index) => {
            const label = document.createElement('label');
            label.className = 'tw-flex tw-cursor-pointer tw-items-start tw-gap-3 tw-rounded-xl tw-border tw-border-solid tw-border-slate-300 tw-p-4';
            const radio = document.createElement('input');
            radio.type = 'radio'; radio.name = 'package'; radio.value = String(index);
            radio.checked = state.package === pkg;
            radio.addEventListener('change', () => { state.package = pkg; error(); });
            const content = document.createElement('span');
            content.className = 'tw-flex-1 tw-space-y-1';
            [pkg.package_name, money(Math.round(pkg.package_price * 100)), pkg.package_description, pkg.package_perk].forEach((text, line) => {
                if (!text) return;
                const span = document.createElement('span');
                span.className = line < 2 ? 'tw-block tw-font-bold tw-text-prime' : 'tw-block tw-text-sm tw-text-slate-600';
                span.textContent = text;
                content.append(span);
            });
            label.append(radio, content);
            list.append(label);
        });
        find('[data-package-legend]').textContent = state.quote ? modal.dataset.quoteServiceLabel : 'Choose your package';
        if (state.quote) list.textContent = modal.dataset.quoteDescription;
    }
    function open(trigger) {
        if (modal.open) return;
        opener = trigger;
        gpsRequest++;
        form.reset();
        Object.keys(state).forEach(key => delete state[key]);
        let packages;
        try { packages = JSON.parse(trigger.dataset.packages || '[]'); } catch { packages = []; }
        Object.assign(state, {
            step: 1, package: null, gps: null, reference: '',
            service: { title: trigger.dataset.serviceTitle || 'Cleaning service', category: trigger.dataset.serviceCategory || 'Services', image: trigger.dataset.serviceImage || '' },
            packages: Array.isArray(packages) ? packages.filter(pkg => pkg && typeof pkg.package_name === 'string' && pkg.package_name.trim() && typeof pkg.package_price === 'number' && Number.isFinite(pkg.package_price) && pkg.package_price >= 0 && pkg.package_price <= Number.MAX_SAFE_INTEGER / 100) : [],
        });
        state.quote = state.packages.length === 0;
        find('[data-service-title]').textContent = state.service.title;
        find('[data-service-category]').textContent = state.service.category;
        const img = find('[data-service-image]');
        // Only accept http(s) images from data attributes.
        try { const url = new URL(state.service.image, location.href); img.hidden = !['https:', 'http:'].includes(url.protocol); if (!img.hidden) img.src = url.href; } catch { img.hidden = true; }
        img.onerror = () => { img.hidden = true; };
        find('[data-gps]').disabled = false;
        find('[data-gps]').textContent = 'Capture GPS location';
        find('[data-clear-gps]').hidden = true;
        find('[data-address]').hidden = false;
        find('[data-gps-status]').textContent = 'Allow location access, or enter your address below.';
        form.elements.date.min = dateToday();
        if (trigger.dataset.packageIndex !== undefined) state.package = state.packages[Number(trigger.dataset.packageIndex)] || null;
        if (['Khobar', 'Dammam', 'Jubail', 'Ras Tanura'].includes(trigger.dataset.bookingCity)) form.elements.city.value = trigger.dataset.bookingCity;
        renderPackages();
        goTo(1, false);
        previousOverflowClass = document.documentElement.classList.contains('nsp-booking-open');
        document.documentElement.classList.add('nsp-booking-open');
        modal.showModal();
        find('#nsp-booking-title').focus();
    }
    function captureGPS() {
        const status = find('[data-gps-status]');
        if (!navigator.geolocation) { status.textContent = 'GPS is unavailable. Please enter your street address and area.'; return; }
        const request = ++gpsRequest;
        find('[data-gps]').disabled = true;
        status.textContent = 'Finding your location…';
        navigator.geolocation.getCurrentPosition(position => {
            if (request !== gpsRequest || !modal.open) return;
            state.gps = { latitude: Number(position.coords.latitude.toFixed(6)), longitude: Number(position.coords.longitude.toFixed(6)) };
            status.textContent = `Location locked: ${state.gps.latitude}, ${state.gps.longitude}`;
            find('[data-gps]').disabled = false;
            find('[data-gps]').textContent = 'Recapture GPS location';
            find('[data-clear-gps]').hidden = false;
            find('[data-address]').hidden = true;
            error();
        }, failure => {
            if (request !== gpsRequest || !modal.open) return;
            find('[data-gps]').disabled = false;
            status.textContent = state.gps ? 'Could not refresh GPS. Your previous location remains locked.' : ({ 1: 'Location access was denied. Please enter your street address and area.', 2: 'Your location is unavailable. Please enter your address.', 3: 'Location capture timed out. Try again or enter your address.' }[failure.code] || 'GPS requires a secure connection. Please enter your address.');
        }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
    }
    function sendRequest() {
        for (let step = 1; step <= 4; step++) {
            if (!validate(step)) { goTo(step); validate(step); return; }
        }
        renderReview();
        const prices = totals();
        const message = ['*New Super Prime — Booking Request*', `Reference: ${state.reference}`, '', ...summaryRows().map(([label, value]) => `${label}: ${value}`), '', ...(state.quote ? [`${modal.dataset.quotePriceLabel}: `, '', modal.dataset.quoteConfirmation] : [`Regular price: ${money(prices.regular)}`, `First Booking Benefit (10%): -${money(prices.discount)}`, `Final price: ${money(prices.final)}`, '', 'Please confirm availability and my booking.'])].join('\n');
        const url = `https://api.whatsapp.com/send?phone=966559357772&text=${encodeURIComponent(message)}`;
        // Stay inside the user click so browsers permit opening WhatsApp.
        window.open(url, '_blank', 'noopener,noreferrer');
    }
    document.addEventListener('click', event => {
        const trigger = event.target.closest('[data-nsp-booking]');
        if (trigger) { event.preventDefault(); open(trigger); }
    });
    find('[data-close]').addEventListener('click', () => modal.close());
    find('[data-back]').addEventListener('click', () => { capture(); goTo(state.step - 1); });
    find('[data-gps]').addEventListener('click', captureGPS);
    find('[data-clear-gps]').addEventListener('click', () => {
        gpsRequest++;
        state.gps = null;
        find('[data-address]').hidden = false;
        find('[data-clear-gps]').hidden = true;
        find('[data-gps]').disabled = false;
        find('[data-gps]').textContent = 'Capture GPS location';
        find('[data-gps-status]').textContent = 'Enter your street address and area below.';
        form.elements.street.focus();
    });
    modal.addEventListener('close', () => {
        gpsRequest++;
        if (!previousOverflowClass) document.documentElement.classList.remove('nsp-booking-open');
        opener?.focus();
        form.reset();
        find('[data-summary]').replaceChildren();
        Object.keys(state).forEach(key => delete state[key]);
    });
    form.addEventListener('submit', event => {
        event.preventDefault();
        if (state.step === 5) sendRequest();
        else if (validate(state.step)) goTo(state.step + 1);
    });
})();
