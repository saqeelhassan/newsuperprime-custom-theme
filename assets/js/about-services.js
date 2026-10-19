(() => {
    'use strict';
    const button = document.querySelector('.nsp-about-services-toggle');
    const list = document.querySelector('#nsp-about-services');
    if (!button || !list) return;
    button.addEventListener('click', () => {
        const expanded = button.getAttribute('aria-expanded') !== 'true';
        button.setAttribute('aria-expanded', String(expanded));
        list.toggleAttribute('data-collapsed', !expanded);
        button.textContent = expanded ? button.dataset.less : button.dataset.more;
    });
})();
