<x-layouts.app>
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Make a Deposit</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-3">{{ session('error') }}</div>
    @endif

    <form id="deposit-form" action="{{ route('user.deposit.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Amount (USD)</label>
            <input type="number" name="amount" min="10" step="0.01" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Currency</label>
            <select name="currency" class="w-full border p-2 rounded" required>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
                <option value="JPY">JPY</option>
                <!-- Add more if needed -->
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Crypto</label>
            <select name="crypto" class="w-full border p-2 rounded" required>
                <option value="BTC">BTC</option>
                <option value="ETH">ETH</option>
                <option value="USDTTRC20">USDT - TRC20</option>
                
                <!-- Add more if needed -->
            </select>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
            Continue to Payment
        </button>
    </form>
</div>

<script>
        document.getElementById('deposit-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            let res = await fetch("{{ route('user.deposit.create') }}", {
                method: "POST",
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            let data = await res.json();

            if (data.invoice_url) {
                window.open(data.invoice_url, "_blank"); // new tab
                window.location.href = "{{ route('user.deposit.history') }}"; // keep current tab on history
            }
        });
    </script>
</x-layouts.app>
