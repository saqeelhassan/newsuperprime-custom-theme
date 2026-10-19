/* Native service package rows. WordPress handles persistence on Update/Publish. */
(() => {
    'use strict';
    function init() {
        const editor = document.querySelector('#nsp-packages-editor');
        if (!editor || editor.dataset.initialized) return;
        editor.dataset.initialized = 'true';
        const rows = editor.querySelector('[data-package-rows]');
        const empty = editor.querySelector('[data-empty-packages]');
        let index = Number(editor.dataset.nextIndex) || 0;
        editor.querySelector('[data-add-package]').addEventListener('click', () => {
            const template = editor.querySelector('template').content.cloneNode(true);
            template.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace('__INDEX__', String(index));
            });
            index++;
            rows.append(template);
            empty.hidden = true;
            rows.lastElementChild.querySelector('input').focus();
        });
        editor.addEventListener('click', event => {
            const remove = event.target.closest('[data-remove-package]');
            if (!remove) return;
            remove.closest('.nsp-package-row').remove();
            empty.hidden = !!rows.children.length;
            editor.querySelector('[data-add-package]').focus();
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
