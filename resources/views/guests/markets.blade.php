<x-layouts.guest>
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-center mb-8">Explore Global Markets</h1>

        <!-- Alpine.js tab system -->
        <div x-data="{ tab: 'forex' }" class="space-y-8">

            <!-- Tabs -->
            <div class="flex flex-wrap justify-center gap-4 border-b pb-2">
                <button @click="tab = 'forex'" :class="{ 'text-blue-600 border-b-2 border-blue-600': tab === 'forex' }"
                    class="px-4 py-2 text-lg font-medium">Forex</button>
                <button @click="tab = 'crypto'" :class="{ 'text-blue-600 border-b-2 border-blue-600': tab === 'crypto' }"
                    class="px-4 py-2 text-lg font-medium">Crypto</button>
                <button @click="tab = 'indices'" :class="{ 'text-blue-600 border-b-2 border-blue-600': tab === 'indices' }"
                    class="px-4 py-2 text-lg font-medium">Indices</button>
                <button @click="tab = 'commodities'" :class="{ 'text-blue-600 border-b-2 border-blue-600': tab === 'commodities' }"
                    class="px-4 py-2 text-lg font-medium">Commodities</button>
            </div>

            <!-- Forex Tab -->
            <div x-show="tab === 'forex'" x-transition style="height: 500px;>
                <h2 class="text-xl font-semibold mb-4">Live Forex Chart</h2>
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <iframe class="w-full h-[500px]" src="https://www.tradingview.com/widgetembed/?symbol=FX:EURUSD&interval=60&theme=light&style=1&timezone=Etc%2FUTC&hideideas=1" frameborder="0"></iframe>
                </div>
            </div>

            <!-- Crypto Tab -->
            <div x-show="tab === 'crypto'" x-transition style="height: 500px;>
                <h2 class="text-xl font-semibold mb-4">Live Crypto Chart</h2>
                <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container" style="height:100%;width:100%">
                    <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
                    <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                    {
                    "autosize": true,
                    "symbol": "BINANCE:BTCUSDT",
                    "interval": "240",
                    "timezone": "Etc/UTC",
                    "theme": "dark",
                    "style": "1",
                    "locale": "en",
                    "allow_symbol_change": true,
                    "details": true,
                    "support_host": "https://www.tradingview.com"
                    }
                    </script>
                    </div>
                    <!-- TradingView Widget END -->
            </div>

            <!-- Indices Tab -->
            <div x-show="tab === 'indices'" x-transition style="height: 500px;>
                <h2 class="text-xl font-semibold mb-4">Live Indices Chart</h2>
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <iframe class="w-full h-[500px]" src="https://www.tradingview.com/widgetembed/?symbol=OANDA:SPX500USD&interval=60&theme=light&style=1&timezone=Etc%2FUTC&hideideas=1" frameborder="0"></iframe>
                </div>
            </div>

            <!-- Commodities Tab -->
            <div x-show="tab === 'commodities'" x-transition style="height: 500px;>
                <h2 class="text-xl font-semibold mb-4">Live Commodities Chart</h2>
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <iframe class="w-full h-[500px]" src="https://www.tradingview.com/widgetembed/?symbol=TVC:GOLD&interval=60&theme=light&style=1&timezone=Etc%2FUTC&hideideas=1" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </section>
</x-layouts.guest>
