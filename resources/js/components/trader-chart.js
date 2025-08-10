import Chart from 'chart.js/auto';

export default function traderChartComponent() {
    return {
        chart: null,
        labels: {},
        roiData: {},
        selectedTimeframe: '1M',
        loading: true,

        initChart(initialData) {
            // Clone deep so Chart.js mutations don't affect Livewire/Alpine reactivity
            this.labels = JSON.parse(JSON.stringify(initialData.labels));
            this.roiData = JSON.parse(JSON.stringify(initialData.roiData));

            this.loading = false;

            this.$nextTick(() => {
                const ctx = this.$refs.chart.getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.labels[this.selectedTimeframe],
                        datasets: [{
                            label: 'ROI %',
                            data: this.roiData[this.selectedTimeframe],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: false,
                        maintainAspectRatio: true
                    }
                });
            });
        },

        updateTimeframe(newTimeframe) {
            this.selectedTimeframe = newTimeframe;
            if (this.chart) {
                this.chart.data.labels = this.labels[newTimeframe];
                this.chart.data.datasets[0].data = this.roiData[newTimeframe];
                this.chart.update('none'); // 'none' = no animation, prevents possible loops
            }
        }
    }
}


window.traderChartComponent = traderChartComponent;
