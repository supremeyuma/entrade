<x-layouts.guest title="Help Center">
    <section class="bg-gray-50 dark:bg-gray-900 py-12 md:py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-2xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 md:mb-4">Need Help?</h1>
            <p class="text-sm md:text-lg text-gray-600 dark:text-gray-300 mb-4 md:mb-6">
                <span class="block md:hidden">Find answers fast.</span>
                <span class="hidden md:block">Find answers to frequently asked questions or get in touch with us.</span>
            </p>
            <div class="max-w-2xl mx-auto">
                <div class="relative">
                    <input
                        type="text"
                        class="w-full rounded-full border border-gray-300 dark:border-gray-700 px-5 md:px-6 py-2.5 md:py-3 pl-11 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Search..."
                    >
                    <div class="absolute left-4 top-2.5 md:top-3 text-gray-400 dark:text-gray-500">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach([
                    ['title' => 'Getting Started', 'desc' => ['short' => 'Start using Entrade.', 'long' => 'Learn how to set up your Entrade account and begin trading.'], 'icon' => '🚀'],
                    ['title' => 'Account & Settings', 'desc' => ['short' => 'Manage your profile.', 'long' => 'Manage your personal info, preferences, and login credentials.'], 'icon' => '⚙️'],
                    ['title' => 'Copy Trading', 'desc' => ['short' => 'Copy top traders.', 'long' => 'Understand how copy trading works and how to follow top traders.'], 'icon' => '📈'],
                    ['title' => 'Trader Info', 'desc' => ['short' => 'For signal providers.', 'long' => 'Info for signal providers, leaderboards, and trader stats.'], 'icon' => '👤'],
                    ['title' => 'Security', 'desc' => ['short' => 'Your data is safe.', 'long' => 'Your data and funds are safe. Learn more about our security.'], 'icon' => '🔒'],
                    ['title' => 'Legal', 'desc' => ['short' => 'Terms & policies.', 'long' => 'Review our terms, disclaimers, and compliance policies.'], 'icon' => '📜'],
                    ['title' => 'Payments', 'desc' => ['short' => 'Deposits & withdrawals.', 'long' => 'Deposit, withdrawal, and transaction-related FAQs.'], 'icon' => '💳'],
                    ['title' => 'Referrals', 'desc' => ['short' => 'Earn by inviting.', 'long' => 'Invite friends and earn rewards with our referral system.'], 'icon' => '🎁'],
                    ['title' => 'Tech Support', 'desc' => ['short' => 'Fix issues fast.', 'long' => 'Having issues? Here’s how to resolve technical problems.'], 'icon' => '🛠️'],
                ] as $category)
                    <a href="#" class="group border border-gray-200 dark:border-gray-700 rounded-xl p-4 md:p-6 hover:shadow-lg transition">
                        <div class="text-2xl md:text-4xl mb-2 md:mb-4">{{ $category['icon'] }}</div>
                        <h3 class="text-base md:text-xl font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600">
                            {{ $category['title'] }}
                        </h3>
                        <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mt-1 md:mt-2">
                            <span class="block md:hidden">{{ $category['desc']['short'] }}</span>
                            <span class="hidden md:block">{{ $category['desc']['long'] }}</span>
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gray-50 dark:bg-gray-900 py-10 md:py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-lg md:text-2xl font-bold text-gray-900 dark:text-white mb-4 md:mb-6">Popular Questions</h2>
            <ul class="space-y-3 md:space-y-4 text-sm md:text-base">
                @foreach([
                    'How do I start copy trading on Entrade?',
                    'How do I withdraw my earnings?',
                    'What are the risks of copy trading?',
                    'How can I become a signal provider?',
                    'Where can I view my trading performance?',
                ] as $question)
                    <li>
                        <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ $question }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="bg-white dark:bg-gray-800 py-10 md:py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-lg md:text-2xl font-bold text-gray-900 dark:text-white mb-3 md:mb-4">Need more help?</h2>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mb-4 md:mb-6">We're here 24/7.</p>
            <a href="{{ route('faq') }}"
               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 md:px-6 md:py-3 rounded-full transition text-sm md:text-base">
                Contact Support
            </a>
        </div>
    </section>
</x-layouts.guest>
