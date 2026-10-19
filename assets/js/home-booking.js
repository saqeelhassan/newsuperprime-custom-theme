(() => {
    'use strict';
    const service = document.querySelector('#nsp-quick-service');
    const city = document.querySelector('#nsp-quick-city');
    const button = document.querySelector('[data-home-booking-submit]');
    const data = document.querySelector('#nsp-quick-booking-data');
    if (!service || !city || !button || !data) return;
    const triggers = [...data.content.querySelectorAll('[data-nsp-booking]')];
    function update() {
        const trigger = service.value === '' ? null : triggers[Number(service.value)];
        for (const key of Object.keys(button.dataset)) if (key !== 'homeBookingSubmit') delete button.dataset[key];
        button.disabled = !trigger;
        if (!trigger) return;
        Object.assign(button.dataset, trigger.dataset, { bookingCity: city.value });
    }
    service.addEventListener('change', update);
    city.addEventListener('change', update);
    update();
})();
