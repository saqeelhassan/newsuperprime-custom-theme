(() => {
    'use strict';
    const root = document.querySelector('#nsp-catalog,[data-home-services]');
    if (!root) return;
    const arabic = document.documentElement.lang.startsWith('ar');
    const text = (en, ar) => arabic ? ar : en;
    const search = root.querySelector('input[type=search]');
    const filters = [...root.querySelectorAll('[data-catalog-filter]')];
    let filter = 'all';
    const normalize = value => value.normalize('NFKD').replace(/[\u0300-\u036f\u064b-\u065f]/g, '').toLocaleLowerCase().trim();
    const matchesCategory = (item, category) => category === 'all' || (item.dataset.serviceCategories || '').split(' ').includes(category);
    function updateResults() {
        if (!root.querySelector('[data-catalog-status]')) return;
        const query = normalize(search?.value || '');
        root.querySelectorAll('[data-catalog-item]').forEach(item => {
            item.hidden = !matchesCategory(item, filter) || !normalize(item.dataset.search).includes(query);
        });
        root.querySelectorAll('[data-results-limit]').forEach(group => {
            const visible = [...group.querySelectorAll('[data-catalog-item]:not([hidden])')];
            visible.slice(Number(group.dataset.resultsLimit)).forEach(item => { item.hidden = true; });
        });
        const count = root.querySelectorAll('.nsp-service-card:not([hidden])').length;
        root.querySelector('[data-no-results]').hidden = count > 0;
        root.querySelector('[data-catalog-status]').textContent = `${count} ${text('services found', 'خدمات متاحة')}`;
        root.querySelectorAll('[data-results-section]').forEach(section => { section.hidden = !section.querySelector('[data-catalog-item]:not([hidden])'); });
        root.querySelectorAll('[data-rail]').forEach(rail => { rail.scrollLeft = 0; });
        root.querySelectorAll('[data-service-hero]').forEach(hero => hero.filterCategory?.(filter));
    }
    filters.forEach(button => button.addEventListener('click', () => {
        filter = button.dataset.catalogFilter;
        filters.forEach(item => item.setAttribute('aria-pressed', String(item === button)));
        updateResults();
    }));
    search?.addEventListener('input', updateResults);
    document.querySelectorAll('[data-service-hero]').forEach(hero => {
    const slides = [...hero.querySelectorAll('[data-hero-slide]')];
    const dots = [...hero.querySelectorAll('[data-hero-dot]')];
    function showHero(index) {
        slides.forEach((slide, i) => { slide.hidden = i !== index; });
        dots.forEach((dot, i) => dot.setAttribute('aria-pressed', String(i === index)));
        if (hero.id === 'clinox-banner-3') {
            const image = slides[index].querySelector('img').src;
            hero.dataset.background = image;
            const ripple = window.jQuery?.(hero);
            if (ripple?.data('ripples')) {
                try { ripple.ripples('set', 'imageUrl', image); }
                catch { /* Static slide image remains available without WebGL. */ }
            }
        }
    }
    dots.forEach(button => button.addEventListener('click', () => showHero(Number(button.dataset.heroDot))));
    hero.filterCategory = category => {
        const eligible = slides.map((slide, index) => matchesCategory(slide, category) ? index : -1).filter(index => index >= 0).slice(0, 4);
        hero.hidden = !eligible.length;
        dots.forEach((dot, index) => { dot.hidden = !eligible.includes(index); });
        if (eligible.length) showHero(eligible[0]);
    };
    hero.filterCategory('all');
    });
    root.querySelectorAll('[data-rail-next],[data-rail-prev]').forEach(button => button.addEventListener('click', () => {
        const next = button.hasAttribute('data-rail-next');
        const rail = root.querySelector(`[data-rail="${next ? button.dataset.railNext : button.dataset.railPrev}"]`);
        rail.scrollBy({ left: rail.clientWidth * .85 * (next ? 1 : -1) * (arabic ? -1 : 1), behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth' });
    }));
    const cityButtons = [...root.querySelectorAll('[data-catalog-city]')];
    function setCity(button) {
        const city = button.dataset.catalogCity;
        cityButtons.forEach(item => item.setAttribute('aria-pressed', String(item.dataset.catalogCity === city)));
        const cityLabel = root.querySelector('[data-current-city]');
        if (cityLabel) cityLabel.textContent = button.firstElementChild.textContent.trim();
        root.querySelectorAll('[data-nsp-booking]').forEach(trigger => { trigger.dataset.bookingCity = city; });
    }
    cityButtons.forEach(button => button.addEventListener('click', () => setCity(button)));
    const selectedCity = cityButtons.find(button => button.getAttribute('aria-pressed') === 'true');
    if (selectedCity) setCity(selectedCity);
    updateResults();
})();
