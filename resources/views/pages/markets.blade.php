<x-layouts.guest>
    <section class="bg-white dark:bg-gray-950 py-16 px-6">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">Markets We Trade On</h1>

            <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
                Entrade supports trading across a wide range of financial markets — empowering our traders with flexibility and users with diverse risk/reward profiles.
            </p>

            <div class="grid md:grid-cols-3 gap-6 mt-10">
                <!-- Stocks -->
                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">📈 Stocks</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        Publicly traded companies from around the world. Stocks are a popular choice for traders who prefer fundamental analysis, trends, and corporate news to drive decisions.
                    </p>
                </div>

                <!-- Forex -->
                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">💱 Forex</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        The foreign exchange market is one of the most liquid in the world. Traders take advantage of currency fluctuations, global economic news, and interest rate changes.
                    </p>
                </div>

                <!-- Crypto -->
                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">₿ Crypto</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        Digital assets like Bitcoin and Ethereum offer high volatility and 24/7 trading opportunities. Perfect for risk-tolerant traders who thrive in dynamic markets.
                    </p>
                </div>
            </div>

            <div class="mt-12 space-y-6">
                <p class="text-gray-700 dark:text-gray-300">
                    Each market comes with its own characteristics, behaviors, and risk profiles. While some traders on Entrade specialize in a single market (e.g., just Forex), others diversify across multiple markets to balance risk and opportunity.
                </p>

                <p class="text-gray-700 dark:text-gray-300">
                    Markets like <strong>stocks</strong> may offer more stability, while <strong>crypto</strong> often presents higher volatility. We encourage users to review trader profiles to understand which markets they operate in before allocating funds.
                </p>

                <p class="text-gray-700 dark:text-gray-300">
                    Entrade ensures transparency by tagging every trade with its respective market so you can easily track where and how your funds are being traded.
                </p>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('traders.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-indigo-700 transition">
                    View Active Traders
                </a>
            </div>
        </div>
    </section>
</x-layouts.guest>
