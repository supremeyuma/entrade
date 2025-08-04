<x-layouts.guest>
    <section class="bg-white dark:bg-gray-950 py-16 px-6">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">Entrade Referral Program</h1>

            <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">
                Share Entrade with your network and earn passive income every time someone signs up and funds their account using your unique referral link.
            </p>

            <div class="mt-8 grid md:grid-cols-2 gap-8">
                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">💰 Earn up to 10%</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        You’ll receive up to <strong>10% commission</strong> on the deposit amounts of every user who joins Entrade using your referral code or link.
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">🔗 Your Unique Referral Link</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        Once logged in, go to your dashboard to find your personal referral link. Share it on social media, messaging apps, or directly with friends.
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">📈 Track Your Earnings</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        The referral dashboard lets you see how many users signed up, how much they deposited, and how much commission you've earned — in real time.
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">📌 Easy Withdrawal</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        Commissions are credited to your wallet and can be withdrawn just like any other balance — subject to minimum withdrawal limits.
                    </p>
                </div>
            </div>

            <div class="mt-10 bg-indigo-100 dark:bg-indigo-900/30 border-l-4 border-indigo-500 dark:border-indigo-400 p-6 rounded">
                <p class="text-gray-800 dark:text-gray-100">
                    🧠 <strong>Tip:</strong> The more value you bring through your referrals — the more you earn. Share your trading journey, post educational content, or invite your investing circle.
                </p>
            </div>

            <div class="mt-10 text-center">
                @auth
                    <a href="{{ route('referral.dashboard') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-indigo-700 transition">
                        Go to Referral Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-indigo-700 transition">
                        Log in to Get Your Referral Link
                    </a>
                @endauth
            </div>
        </div>
    </section>
</x-layouts.guest>
