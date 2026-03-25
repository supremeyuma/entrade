<x-layouts.admin>
    <div class="max-w-4xl mx-auto px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
        <h1 class="mb-4 text-xl font-bold sm:mb-6 sm:text-2xl">Generate Historical Trades</h1>

        @if (session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-50 p-4 text-emerald-700 shadow dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-rose-50 p-4 text-rose-700 shadow dark:bg-rose-500/10 dark:text-rose-300"><ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('admin.trade-bot.generate') }}" method="POST" id="tradeBotForm" class="space-y-4 rounded-[20px] bg-white p-4 shadow-sm dark:bg-slate-900 sm:space-y-6 sm:p-6">
            @csrf
            <div><label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Start Date</label><input type="date" name="start_date" class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 shadow-sm dark:border-slate-700 dark:bg-slate-800" required></div>
            <div><label class="block text-sm font-medium text-slate-700 dark:text-slate-300">End Date</label><input type="date" name="end_date" class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 shadow-sm dark:border-slate-700 dark:bg-slate-800" required></div>
            <div><label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Trading Pairs (optional)</label><textarea name="trading_pairs" rows="3" placeholder="e.g. BTC/USDT, EUR/USD" class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 shadow-sm dark:border-slate-700 dark:bg-slate-800"></textarea><p class="mt-1 text-xs text-slate-500">Separate pairs with commas.</p></div>
            <div><label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Select User</label><select name="user_id" class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 shadow-sm dark:border-slate-700 dark:bg-slate-800" required><option value="">-- Select user --</option>@foreach ($users as $u)<option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Net Profit (currency)</label><input type="number" name="net_profit" step="0.01" class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 shadow-sm dark:border-slate-700 dark:bg-slate-800" required></div>
            <h3 class="mb-2 mt-6 text-lg font-semibold">Advanced Options</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div><label for="desired_win_rate">Desired Win Rate (%)</label><input type="number" step="0.1" min="0" max="100" name="desired_win_rate" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 dark:border-slate-700 dark:bg-slate-800" placeholder="Optional" /></div>
                <div><label for="max_trades">Maximum Trades (cap)</label><input type="number" min="1" name="max_trades" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 dark:border-slate-700 dark:bg-slate-800" placeholder="Optional" /></div>
            </div>
            <div class="pt-4"><button type="submit" class="rounded-2xl bg-sky-600 px-5 py-2 text-sm font-semibold text-white shadow transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">Generate Trades</button></div>
        </form>
    </div>
</x-layouts.admin>
