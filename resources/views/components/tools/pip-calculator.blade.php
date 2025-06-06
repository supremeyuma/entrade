<section id="pip-calculator">
    <h2 class="text-2xl font-semibold mb-4">Pip Calculator</h2>
    <div class="grid md:grid-cols-4 gap-4 text-sm">
        <input id="lot-size" type="number" placeholder="Lot Size" class="border p-2 rounded w-full">
        <input id="pip-value" type="number" placeholder="Pip Size (e.g. 0.0001)" class="border p-2 rounded w-full">
        <input id="pair-rate" type="number" placeholder="Exchange Rate" class="border p-2 rounded w-full">
        <button onclick="calculatePip()" class="bg-blue-600 text-white px-4 py-2 rounded">Calculate</button>
    </div>
    <p id="pip-result" class="mt-3 text-green-600 font-medium"></p>

    <script>
        function calculatePip() {
            const lot = parseFloat(document.getElementById('lot-size').value);
            const pip = parseFloat(document.getElementById('pip-value').value);
            const rate = parseFloat(document.getElementById('pair-rate').value);
            if (lot && pip && rate) {
                const pipValue = (lot * 100000) * pip / rate;
                document.getElementById('pip-result').textContent = `Pip Value: ${pipValue.toFixed(2)} USD`;
            }
        }
    </script>
</section>
