/* Service details and package selection before the five-step booking wizard. */
(() => {
    'use strict';
    const modal = document.querySelector('#nsp-service-preview');
    if (!modal) return;
    const find = selector => modal.querySelector(selector);
    const arabic = document.documentElement.lang.startsWith('ar');
    const text = (en, ar) => arabic ? ar : en;
    const formatPrice = value => `${new Intl.NumberFormat(arabic ? 'ar-SA' : 'en-SA', { maximumFractionDigits: 2 }).format(value)} ${text('SAR', 'ر.س')}`;
    const continueButton = find('[data-preview-continue]');
    let source;
    let returnFocus;
    let handingOff = false;
    let previousLock = false;
    const serviceSelect = find('[data-preview-service]');
    const serviceTriggers = [...find('[data-preview-service-data]').content.querySelectorAll('[data-nsp-booking]')];
    function choose(index, packages) {
        continueButton.dataset.packageIndex = String(index);
        find('[data-preview-price]').textContent = formatPrice(packages[index].package_price);
    }
    function open(trigger, clicked) {
        const switching = modal.open;
        source = trigger;
        if (!switching) returnFocus = clicked.closest('dialog') ? document.querySelector('#clinox-header a') : (clicked.closest('a,button') || trigger);
        serviceSelect.value = String(serviceTriggers.findIndex(item => item.dataset.serviceTitle === trigger.dataset.serviceTitle));
        handingOff = false;
        for (const key of Object.keys(continueButton.dataset)) {
            if (key !== 'previewContinue' && key !== 'nspBooking') delete continueButton.dataset[key];
        }
        for (const [key, value] of Object.entries(trigger.dataset)) continueButton.dataset[key] = value;
        const title = trigger.dataset.serviceTitle || text('Our service', 'خدماتنا');
        find('#nsp-preview-title').textContent = title;
        find('[data-preview-category]').textContent = trigger.dataset.serviceCategory || text('Professional service', 'خدمة احترافية');
        const overview = trigger.dataset.serviceOverview || text('Professional care tailored to your space. Choose a package or contact our team for details.', 'عناية احترافية تناسب مساحتك. اختر باقة أو تواصل مع فريقنا للتفاصيل.');
        find('[data-preview-overview]').textContent = overview;
        find('[data-preview-subtitle]').textContent = overview;
        const image = find('[data-preview-image]');
        image.hidden = true;
        try {
            const url = new URL(trigger.dataset.serviceImage, location.href);
            if (['http:', 'https:'].includes(url.protocol)) { image.src = url.href; image.hidden = false; }
        } catch { /* Retain the solid hero background for invalid images. */ }
        image.onerror = () => { image.hidden = true; };
        let packages;
        try { packages = JSON.parse(trigger.dataset.packages || '[]'); } catch { packages = []; }
        packages = Array.isArray(packages) ? packages.filter(pkg => pkg && typeof pkg.package_name === 'string' && pkg.package_name.trim() && typeof pkg.package_price === 'number' && Number.isFinite(pkg.package_price) && pkg.package_price >= 0 && pkg.package_price <= Number.MAX_SAFE_INTEGER / 100) : [];
        // Keep package indices identical to the normalized data sent to the wizard.
        continueButton.dataset.packages = JSON.stringify(packages);
        const selected = packages[Number(trigger.dataset.packageIndex)] ? Number(trigger.dataset.packageIndex) : 0;
        const list = find('[data-preview-packages]');
        list.replaceChildren();
        packages.forEach((pkg, index) => {
            const label = document.createElement('label');
            label.className = 'nsp-preview-package';
            const radio = document.createElement('input');
            radio.type = 'radio'; radio.name = 'preview-package'; radio.value = String(index); radio.checked = index === selected;
            radio.addEventListener('change', () => choose(index, packages));
            label.append(radio);
            for (const [tag, className, content] of [
                ['strong', '', pkg.package_name], ['span', 'nsp-preview-package-price', formatPrice(pkg.package_price)],
                ['span', 'nsp-preview-package-description', pkg.package_description], ['span', 'nsp-preview-package-perk', pkg.package_perk ? `✦ ${pkg.package_perk}` : ''],
            ]) {
                if (!content) continue;
                const node = document.createElement(tag); node.className = className; node.textContent = content; label.append(node);
            }
            list.append(label);
        });
        continueButton.hidden = !packages.length;
        find('[data-preview-quote]').hidden = !!packages.length;
        find('[data-preview-empty]').hidden = !!packages.length;
        if (packages.length) choose(selected, packages);
        else find('[data-preview-price]').textContent = trigger.dataset.priceLabel || text('Price on request', 'السعر عند الطلب');
        if (!switching) previousLock = document.documentElement.classList.contains('nsp-preview-open');
        document.documentElement.classList.add('nsp-preview-open');
        if (!switching) modal.showModal();
        find('.nsp-preview-body').scrollTop = 0;
        if (!switching) find('#nsp-preview-title').focus({ preventScroll: true });
    }
    function changeService(index) {
        if (!serviceTriggers.length) return;
        const target = serviceTriggers[(index + serviceTriggers.length) % serviceTriggers.length];
        target.dataset.bookingCity = continueButton.dataset.bookingCity || '';
        open(target, serviceSelect);
    }
    serviceSelect.addEventListener('change', () => changeService(Number(serviceSelect.value)));
    find('[data-preview-prev]').addEventListener('click', () => changeService(Number(serviceSelect.value) - 1));
    find('[data-preview-next]').addEventListener('click', () => changeService(Number(serviceSelect.value) + 1));
    // Capture before the existing booking click handler so cards show details first.
    document.addEventListener('click', event => {
        if (event.button !== 0 || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || modal.contains(event.target)) return;
        let trigger = event.target.closest('[data-nsp-booking]');
        const card = event.target.closest('.nsp-service-card,.nsp-specialized-card,.clinox-service-item-3');
        if (!trigger && card) {
            trigger = card.querySelector('[data-nsp-booking]');
            if (!trigger && card.dataset.serviceKey) {
                const peer = [...document.querySelectorAll('.nsp-service-card')].find(item => item.dataset.serviceKey === card.dataset.serviceKey);
                trigger = peer?.querySelector('[data-nsp-booking]');
            }
        }
        if (!trigger) return;
        event.preventDefault();
        event.stopImmediatePropagation();
        const sourceDialog = trigger.closest('dialog');
        if (sourceDialog?.open && sourceDialog !== modal) {
            sourceDialog.dispatchEvent(new Event('nsp:handoff'));
            sourceDialog.close();
        }
        open(trigger, event.target);
    }, true);
    find('[data-preview-close]').addEventListener('click', () => modal.close());
    continueButton.addEventListener('click', () => {
        handingOff = true;
        modal.close();
        // The original booking handler receives this click after the preview closes.
    });
    modal.addEventListener('close', () => {
        if (!previousLock) document.documentElement.classList.remove('nsp-preview-open');
        if (handingOff) {
            // Keep focus restoration outside the now-closed preview on wizard close.
            const booking = document.querySelector('#nsp-booking');
            const focusSource = returnFocus || source;
            if (booking?.open) booking.addEventListener('close', () => focusSource?.focus({ preventScroll: true }), { once: true });
        } else returnFocus?.focus({ preventScroll: true });
    });
})();
