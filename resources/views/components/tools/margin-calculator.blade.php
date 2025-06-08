<section id="margin-calculator">
    <h2 class="text-2xl font-semibold mb-4">Margin Calculator</h2>
    <div class="grid md:grid-cols-4 gap-4 text-sm">
        <input id="mc-lots" type="number" placeholder="Lots" class="border p-2 rounded w-full">
        <input id="mc-leverage" type="number" placeholder="Leverage (e.g. 100)" class="border p-2 rounded w-full">
        <input id="mc-price" type="number" placeholder="Price (e.g. 1.1000)" class="border p-2 rounded w-full">
        <button onclick="calculateMargin()" class="bg-blue-600 text-white px-4 py-2 rounded">Calculate</button>
    </div>
    <p id="margin-result" class="mt-3 text-green-600 font-medium"></p>


    <script>
        function calculateMargin() {
            const lots = parseFloat(document.getElementById('mc-lots').value);
            const leverage = parseFloat(document.getElementById('mc-leverage').value);
            const price = parseFloat(document.getElem        <div class="relative" @mouseenter="toolsOpen = true" @mouseleave="toolsOpen = false">
            <button class="hover:underline focus:outline-none">Tools</button>
            <div
                x-show="toolsOpen"
                x-transition
                class="absolute z-50 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5"
            >
                <div class="py-1 text-sm text-gray-700 dark:text-gray-200">
                    <a href="{{ url('/tools?section=economic-calendar') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Economic Calendar</a>
                    <a href="{{ url('/tools?section=market-news') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Market News</a>
                    <a href="{{ url('/tools?section=trading-signals') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Trading Signals</a>
                    <a href="{{ url('/tools?section=pip-calculator') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Pip Calculator</a>
                    <a href="{{ url('/tools?section=copy-guide') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Copy Guide</a>
                    <a href="{{ url('/tools?section=trading-hours') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Trading Hours</a>
                    <a href="{{ url('/tools?section=risk-tips') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Risk Tips</a>
                    <a href="{{ url('/tools?section=currency-converter') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Currency Converter</a>
                    <a href="{{ url('/tools?section=margin-calculator') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Margin Calculator</a>
                    <a href="{{ url('/tools?section=live-charts') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Live Charts</a>
                </div>
            </div>
        </div>entById('mc-price').value);
            if (lots && leverage && price) {
                const margin = (lots * 100000 * price) / leverage;
                document.getElementById('margin-result').textContent = `Required Margin: $${margin.toFixed(2)}`;
            }
        }
    </script>
</section>
