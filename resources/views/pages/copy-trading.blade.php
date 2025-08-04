<x-layouts.guest>
    <section class="bg-white dark:bg-gray-950 py-16 px-6">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">Copy Trading on Entrade</h1>

            <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">
                Entrade’s Copy Trading system allows you to replicate the trading performance of top traders automatically.
                Whether you're new to trading or looking for passive growth, copy trading makes it easy to participate in the markets with expert guidance.
            </p>

            <div class="grid md:grid-cols-2 gap-8 mt-10">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">How It Works</h2>
                    <ul class="space-y-4 list-disc list-inside text-gray-700 dark:text-gray-300">
                        <li>
                            <strong>Browse & Select a Trader:</strong> Explore our marketplace of verified traders, review their ROI, strategy, and performance history.
                        </li>
                        <li>
                            <strong>Allocate Funds:</strong> Choose how much capital you want to allocate to copy each trader.
                        </li>
                        <li>
                            <strong>Approval Process:</strong> For risk management, all fund allocations must be approved by our admin team.
                        </li>
                        <li>
                            <strong>Start Copying:</strong> Once approved, you will automatically mirror the trader's trades.
                        </li>
                        <li>
                            <strong>Get Paid:</strong> When the trader earns an ROI on a trade, you receive the same ROI proportional to your allocated amount.
                        </li>
                        <li>
                            <strong>Withdraw or Reallocate:</strong> You can reallocate or withdraw your funds at any time (subject to system policies).
                        </li>
                    </ul>
                </div>

                <div>
                    <img src="{{ asset('images/copy-trading-illustration.png') }}" alt="Copy Trading Illustration" class="rounded-xl shadow-md w-full h-auto">
                </div>
            </div>

            <div class="mt-16 bg-gray-100 dark:bg-gray-800 p-8 rounded-lg shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Example:</h3>
                <p class="text-gray-700 dark:text-gray-300">
                    If you allocate <strong>$10,000</strong> to a trader and they make a trade that returns <strong>+20% ROI</strong>, your trade balance will be credited with <strong>$2,000 profit</strong>, bringing your total to <strong>$12,000</strong>.
                </p>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('traders.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-indigo-700 transition">
                    Browse Traders
                </a>
            </div>
        </div>
    </section>
</x-layouts.guest>
