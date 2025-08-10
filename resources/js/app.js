import './bootstrap';

import './components/traderCard.js';

import './components/trader-chart.js';

import traderChartComponent from './components/trader-chart';

window.traderChartComponent = traderChartComponent;


document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        isDark: localStorage.getItem('theme') === 'dark',
    });
});




