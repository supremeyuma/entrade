import './bootstrap';

import './components/traderCard.js';

import traderChartComponent from './components/trader-chart.js';

window.traderChartComponent = traderChartComponent;


document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        isDark: localStorage.getItem('theme') === 'dark',
    });
});




