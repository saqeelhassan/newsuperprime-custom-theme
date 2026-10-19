/* Bootstrap-compatible FAQ Collapse data API; native booking dialogs are separate. */
(() => {
    const animations = new WeakMap();
    const controls = target => [...document.querySelectorAll('[data-bs-toggle="collapse"]')].filter(button => button.getAttribute('data-bs-target') === '#' + target.id || button.getAttribute('href') === '#' + target.id);
    function set(panel, open) {
        const from = panel.getBoundingClientRect().height;
        animations.get(panel)?.cancel();
        if (open) panel.classList.add('show');
        controls(panel).forEach(button => {
            button.classList.toggle('collapsed', !open);
            button.setAttribute('aria-expanded', String(open));
        });
        const complete = () => {
            panel.classList.toggle('show', open);
            panel.style.overflow = '';
            animations.delete(panel);
            panel.dispatchEvent(new Event(open ? 'shown.bs.collapse' : 'hidden.bs.collapse', {bubbles:true}));
        };
        if (!panel.animate || matchMedia('(prefers-reduced-motion: reduce)').matches) return complete();
        panel.style.overflow = 'hidden';
        const animation = panel.animate([{height:from + 'px'}, {height:(open ? panel.scrollHeight : 0) + 'px'}], {duration:350, easing:'ease'});
        animations.set(panel, animation);
        animation.onfinish = complete;
    }
    document.addEventListener('click', event => {
        const button = event.target.closest('[data-bs-toggle="collapse"]');
        if (!button) return;
        const selector = button.getAttribute('data-bs-target') || button.getAttribute('href');
        if (!selector || !selector.startsWith('#')) return;
        const panel = document.getElementById(selector.slice(1));
        if (!panel) return;
        event.preventDefault();
        const open = button.getAttribute('aria-expanded') !== 'true';
        if (open && panel.dataset.bsParent) {
            const parent = document.querySelector(panel.dataset.bsParent);
            parent?.querySelectorAll('.collapse.show').forEach(other => { if (other !== panel) set(other, false); });
        }
        set(panel, open);
    });
})();
