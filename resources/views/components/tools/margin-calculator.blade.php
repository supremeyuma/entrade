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
            const price = parseFloat(document.getElementById('mc-price').value);
            if (lots && leverage && price) {
                const margin = (lots * 100000 * price) / leverage;
                document.getElementById('margin-result').textContent = `Required Margin: $${margin.toFixed(2)}`;
            }
        }
    </script>
</section>
