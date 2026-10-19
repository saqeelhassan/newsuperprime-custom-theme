/* Isolate page/booking checks; special-offers.cjs tests the marketing popup. */
module.exports = async page => {
    await page.addInitScript(() => {
        document.addEventListener('DOMContentLoaded', () => document.querySelector('#nsp-special-offers')?.remove(), { once: true });
    });
};
