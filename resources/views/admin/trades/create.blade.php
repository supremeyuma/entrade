<x-layouts.admin>
    <div class="space-y-3 sm:space-y-6 max-w-3xl">
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border border-slate-200 bg-white text-slate-900 shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl dark:border-slate-800 dark:bg-slate-950 dark:text-white">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)] dark:bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.18),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,_#020617,_#0f172a_58%,_#111827)]"></div>
                <div class="relative"><p class="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400 sm:tracking-[0.24em]">Admin</p><h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl">Add Trade for {{ $trader->name }}</h1></div>
            </div>
        </section>

        <form method="POST" action="{{ route('admin.traders.trades.store', $trader) }}" data-aos="fade-up" data-aos-delay="120" class="space-y-4 rounded-[20px] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:space-y-6 sm:p-6">
            @csrf
            <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Asset</label><input type="text" name="asset" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800" placeholder="e.g., XAUUSD"></div>
            <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Pair (optional)</label><input type="text" name="pair" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800" placeholder="e.g., EURUSD"></div>
            <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Trade Type</label><select name="trade_type" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800" required><option value="buy">Buy</option><option value="sell">Sell</option></select></div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Entry Price</label><input type="number" name="entry_price" step="0.0001" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Exit Price</label><input type="number" name="exit_price" step="0.0001" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Lot Size</label><input type="number" name="lot_size" step="0.01" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Profit/Loss</label><input type="number" name="profit_loss" step="0.01" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Stop Loss</label><input type="number" name="stop_loss" step="0.0001" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Take Profit</label><input type="number" name="take_profit" step="0.0001" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Opened At</label><input type="datetime-local" name="opened_at" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Closed At</label><input type="datetime-local" name="closed_at" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
            </div>
            <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Executed At</label><input type="datetime-local" name="executed_at" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
            <div><label class="mb-1 block text-sm font-medium text-slate-500 dark:text-slate-400">Status</label><select name="status" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800" required><option value="closed">Closed</option><option value="pending">Pending</option></select></div>
            <div class="flex justify-end"><button type="submit" class="rounded-2xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">Save Trade</button></div>
        </form>
    </div>
</x-layouts.admin>
