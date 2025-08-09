import './bootstrap';

import Alpine from 'alpinejs';

import './components/traderCard.js';



document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        isDark: localStorage.getItem('theme') === 'dark',
    });
});

window.Alpine = Alpine;

Alpine.start();
