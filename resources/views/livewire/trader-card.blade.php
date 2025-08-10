<div 
    wire:ignore
    x-data="{
        chart: null,
        initChart(timeframe) {
            const ctx = this.$refs.chart.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @this.labels,
                    datasets: [{
                        label: 'ROI %',
                        data: @this.roiData,
                        borderColor: '#4F46E5',
                        fill: false
                    }]
                }
            });
            
            Livewire.on('chartUpdated', (data) => {
                this.chart.data.labels = data.labels;
                this.chart.data.datasets[0].data = data.roiData;
                this.chart.update();
            });
        }
    }"
    x-init="initChart('1M')"

    wire:poll.10s="refreshChart"
    class="bg-white dark:bg-gray-900 rounded-xl shadow p-4 w-full max-w-sm"
>

    <h3 class="text-lg font-semibold">{{ $trader->name }}</h3>

    <canvas x-ref="chart" class="w-full h-40"></canvas>

    <div class="flex justify-end mt-2 space-x-2 text-xs">
        <button @click="updateTimeframe('1W')" 
            :class="selectedTimeframe === '1W' ? 'font-bold underline' : ''">
            1W
        </button>
        <button @click="updateTimeframe('1M')" 
            :class="selectedTimeframe === '1M' ? 'font-bold underline' : ''">
            1M
        </button>
        <button @click="updateTimeframe('12M')" 
            :class="selectedTimeframe === '12M' ? 'font-bold underline' : ''">
            12M
        </button>
    </div>
</div>



<script>
    document.addEventListener('livewire:updateChart', e => {
        window.dispatchEvent(new CustomEvent('updateChart', { detail: e.detail }));
    });
</script>
