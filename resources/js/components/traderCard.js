function traderCard() {
    return {
        chart: null,
        roiSeries: {},
        selectedTimeframe: '1M',
        currentRoi: 0,
        loading: true,
        

        initChart(roiData) {
            //Destroy existing chart if any
            if (this.chart) {
                this.chart.destroy();
            }
            // Clone the data to break Alpine's reactivity
            this.roiSeries = JSON.parse(JSON.stringify(roiData));
            setTimeout(() => {
                this.loading = false;
                this.drawChart();
                this.updateTimeframe(this.selectedTimeframe);
            }, 500);
        },

        drawChart() {
             if (!this.roiSeries || !this.$refs.chart) return;

             if (this.chart) {
                this.chart.destroy();
            }

            const ctx = this.$refs.chart.getContext('2d');

            // Use Alpine.raw() to get non-reactive data
            const rawData = Alpine.raw(this.roiSeries[this.selectedTimeframe]) || [];

            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array(rawData.length).fill(''),
                    datasets: [{
                        label: 'ROI',
                        data: rawData,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 3, // Optional: increase point size
                        pointHoverRadius: 5, // Optional: increase point size on hover
                        pointHoverBackgroundColor: '#6366f1', // Optional: change point color on hover
                        tension: 0.3, // Optional: smooth curve
                    //pointRadius: 0 // Optional: remove points
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                    
                }
            });
        },

        updateTimeframe(tf) {
            if (!this.chart || !this.roiSeries) return;

            this.selectedTimeframe = tf;
            const data = this.roiSeries[tf] ?? [];
            this.chart.data.datasets[0].data = data;
            this.chart.data.labels = Array(data.length).fill('');
            this.chart.update();
            this.currentRoi = data.length > 0 ? data[data.length - 1] : 0; data[data.length - 1] ?? 0;
        }
    }
}

// ✅ Register globally for Alpine to access
window.traderCard = traderCard;
