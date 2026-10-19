module.exports = {
  content: ['./template-parts/booking/*.php', './assets/js/booking.js'],
  corePlugins: { preflight: false },
  important: '#nsp-booking',
  prefix: 'tw-',
  theme: { extend: { colors: { prime: '#188c3a', ink: '#16354a', mist: '#f1f7f8' } } },
};
