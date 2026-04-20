<x-layouts.guest>
    <section class="bg-white dark:bg-gray-950 py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">Meet the Traders</h1>

            <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
                At Bullsbybit, we don’t just allow anyone to manage your capital. Every trader on our platform is thoroughly vetted with a proven track record, real trading experience, and performance metrics that speak for themselves.
            </p>

            <div class="grid md:grid-cols-2 gap-6 mb-12">
                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">🔍 Search & Filter</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        Use filters to find traders based on their preferred market (Forex, Crypto, Stocks), average ROI, risk level, subscriber count, and performance consistency.
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">📊 Trader Stats</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        Each trader profile includes a monthly ROI chart, total trades, win rate, average holding time, and recent performance — helping you make informed allocation decisions.
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">🤝 Copy with Confidence</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        Once you find a trader you trust, allocate funds to copy them. Every time they make a trade, you get the same ROI automatically based on your allocation.
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">🔐 Vetted & Verified</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        Traders must meet strict eligibility criteria, including multi-year profitability, consistent strategy, and admin approval before being listed.
                    </p>
                </div>
            </div>

            <div class="bg-indigo-100 dark:bg-indigo-900/30 border-l-4 border-indigo-500 dark:border-indigo-400 p-6 rounded mb-10">
                <p class="text-gray-800 dark:text-gray-100">
                    📌 <strong>Note:</strong> Copying a trader does not mean transferring control of your funds — it simply mirrors their performance. You can withdraw or adjust your allocations at any time.
                </p>
            </div>

            <div class="text-center">
                <a href="{{ route('traders.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-indigo-700 transition">
                    Browse Verified Traders
                </a>
            </div>
        </div>
    </section>
</x-layouts.guest>
