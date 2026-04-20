<x-layouts.guest>
{{-- Changed px-4 md:px-6 to px-0 sm:px-4 md:px-6 for no margin on small screens --}}
<section class="pt-12 md:pt-16 px-0 sm:px-4 md:px-6 bg-white dark:bg-gray-800 transition-colors duration-500">
    {{-- Adjusted text sizes: text-xl md:text-2xl (h1), text-sm md:text-lg (p) --}}
    <div class="max-w-4xl mx-auto text-center mb-8 md:mb-12">
        <h1 class="text-xl sm:text-2xl md:text-4xl font-extrabold leading-tight mb-3 md:mb-4 text-gray-900 dark:text-white">
            Effortless Copy Trading
        </h1>
        <p class="text-sm sm:text-base md:text-lg max-w-2xl mx-auto">
            Powered by Verified Crypto Traders — grow your crypto portfolio with confidence by copying top traders.
        </p>
    </div>

    {{-- Added px-4 for a small buffer on mobile video, if desired. Otherwise, px-0. --}}
    {{-- I've added px-4 for the video itself to avoid it touching the very edges, but kept the section px-0 --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-0">
        <video id="heroVideo"
               class="w-full h-auto max-w-full rounded-lg shadow-lg mx-auto"
               autoplay muted playsinline preload="auto"
               src="https://cdn.sanity.io/files/uswo7bx0/production/97783b225d2d81433828edb874e0f030f3f96f52.mp4"
               type="video/mp4"
               ></video>
    </div>

    <div class="max-w-4xl mx-auto text-center mt-8 md:mt-12">
        {{-- Adjusted text size: text-sm md:text-lg (p) --}}
        <p class="text-sm sm:text-base md:text-lg max-w-2xl mx-auto">
            Track performance, control risk, and automate your investments on a transparent platform.
        </p>
        {{-- Adjusted button padding: px-4 py-2 md:px-8 md:py-4 --}}
        {{-- Adjusted button font size: text-sm md:text-base --}}
        <div class="flex flex-col sm:flex-row justify-center gap-3 md:gap-6 mt-6 md:mt-8">
            <a href="{{ route('register') }}"
               class="bg-indigo-700 dark:bg-indigo-300 dark:text-indigo-900 text-white font-bold px-4 py-2 sm:px-6 sm:py-3 md:px-8 md:py-4 rounded-lg shadow-lg hover:bg-indigo-600 dark:hover:bg-indigo-400 transition text-sm sm:text-base">
                Get Started Free
            </a>
            <a href="{{ route('leaderboard.public') }}"
               class="border border-indigo-700 dark:border-indigo-300 hover:bg-indigo-700 dark:hover:bg-indigo-300 hover:text-white dark:hover:text-indigo-900 px-4 py-2 sm:px-6 sm:py-3 md:px-8 md:py-4 rounded-lg font-semibold transition text-sm sm:text-base">
                Explore Top Traders
            </a>
        </div>

        {{-- Adjusted stat sizes: text-xl md:text-3xl (numbers), text-xs md:text-sm (labels) --}}
        <div class="flex flex-wrap justify-center gap-4 md:gap-12 mt-8 md:mt-12">
            <div class="flex flex-col items-center text-gray-900 dark:text-white">
                <span class="text-xl sm:text-2xl md:text-3xl font-extrabold">100K+</span>
                <span class="text-xs sm:text-sm">Users Worldwide</span>
            </div>
            <div class="flex flex-col items-center text-gray-900 dark:text-white">
                <span class="text-xl sm:text-2xl md:text-3xl font-extrabold">250+</span>
                <span class="text-xs sm:text-sm">Verified Traders</span>
            </div>
            <div class="flex flex-col items-center text-gray-900 dark:text-white">
                <span class="text-xl sm:text-2xl md:text-3xl font-extrabold">50M+</span>
                <span class="text-xs sm:text-sm">Assets Managed</span>
            </div>
        </div>
    </div>
</section>

{{-- Removed redundant script tag here, it's already at the bottom --}}

<section class="pt-12 md:pt-16 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
    {{-- Changed px-4 to px-0 sm:px-4 for no margin on small screens --}}
    <div class="container mx-auto px-0 sm:px-4  md:space-y-20">
        {{-- Section 1 --}}
        <div class="flex flex-col lg:flex-row items-center gap-6 md:gap-8">
            {{-- Image hidden on small screens too (hidden md:block) --}}
            <div class="w-full lg:w-1/2 hidden sm:block">
                {{-- Adjusted image size: h-48 sm:h-auto (on small screens, max height will be 48, then auto) --}}
                <img src="https://cdn.sanity.io/images/uswo7bx0/production/4a499068f6fce07021829be6a1f3a2612501afd7-426x327.webp?auto=format"
                     alt="Trading is hard"
                     class="mx-auto h-48 sm:h-auto" height="350">
            </div>
            <div class="w-full lg:w-1/2 px-4 sm:px-0"> {{-- Added px-4 for internal padding on small screens --}}
                {{-- Adjusted text sizes: text-xl md:text-3xl (h2), text-sm md:text-base (span, p) --}}
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-3 md:mb-4">Truth is... <br> Trading is not easy</h2>
                <div class="mb-3 flex items-center">
                    {{-- Adjusted icon size: w-4 h-4 mr-1 (for sm screens), w-5 h-5 mr-2 (for md screens) --}}
                    <img src="https://cdn.sanity.io/images/uswo7bx0/production/2fd3ca4ccb56a3d567a86c2f73c10722889e8c72-383x383.svg?auto=format"
                         alt="Clock icon" class="w-4 h-4 mr-1 sm:w-5 sm:h-5 sm:mr-2">
                    <span class="text-sm sm:text-base">Studying the market takes time</span>
                </div>
                <div class="mb-3 flex items-center">
                    {{-- Adjusted icon size: w-4 h-4 mr-1 (for sm screens), w-5 h-5 mr-2 (for md screens) --}}
                    <img src="https://cdn.sanity.io/images/uswo7bx0/production/0a26a0aa4b88a029244bf62419d3d15e00b501a4-382x383.svg?auto=format"
                         alt="Building icon" class="w-4 h-4 mr-1 sm:w-5 sm:h-5 sm:mr-2">
                    <span class="text-sm sm:text-base">Building and maintaining a trading strategy is hard</span>
                </div>
                <div class="mb-4 flex items-start">
                    <p class="text-sm sm:text-base">That's why only <strong>11-26% of manual investors</strong> end up winning.</p>
                    {{-- Adjusted info icon size: w-4 h-4 text-gray-400 (for sm screens), w-5 h-5 text-gray-500 (for md screens) --}}
                    {{-- Adjusted tooltip width: w-56 sm:w-64 --}}
                    <div class="relative group ml-1 sm:ml-2 cursor-pointer">
                        <svg class="w-4 h-4 text-gray-400 sm:w-5 sm:h-5 sm:text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <div class="absolute z-10 hidden group-hover:block bg-gray-200 dark:bg-gray-800 text-xs sm:text-sm text-gray-800 dark:text-gray-100 p-2 sm:p-3 rounded shadow-md top-6 left-0 w-56 sm:w-64">
                            "Between 74-89% of retail investor accounts lose money when trading CFDs." (source: <span class="font-semibold">ESMA</span>)
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2 --}}
        <div class="flex flex-col lg:flex-row-reverse items-center gap-6 md:gap-8">
            {{-- Image hidden on small screens too (hidden md:block) --}}
            <div class="w-full lg:w-1/2 hidden sm:block">
                {{-- Adjusted image size: h-48 sm:h-auto (on small screens, max height will be 48, then auto) --}}
                <img src="https://cdn.sanity.io/images/uswo7bx0/production/cdbbacb2e17b1b0066398ab12312952b056309f3-352x414.webp?auto=format"
                     alt="Copy trading benefits" class="mx-auto h-48 sm:h-auto" height="350">
            </div>
            <div class="w-full lg:w-1/2 text-left md:text-right px-4 sm:px-0"> {{-- Added px-4 for internal padding on small screens --}}
                {{-- Adjusted text sizes: text-xl md:text-3xl (h2), text-sm md:text-base (p, a, button) --}}
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-3 md:mb-4">Beat the odds with Copy Trading</h2>
                <div class="mb-4 flex items-start md:justify-end">
                    <p class="text-sm sm:text-base">Did you know that <strong>73% of our investors make profit</strong> when copying top leaders correctly?</p>
                    {{-- Adjusted info icon size and tooltip width --}}
                    <div class="relative group ml-1 sm:ml-2 cursor-pointer">
                        <svg class="w-4 h-4 text-gray-400 sm:w-5 sm:h-5 sm:text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <div class="absolute z-10 hidden group-hover:block bg-gray-200 dark:bg-gray-800 text-xs sm:text-sm text-gray-800 dark:text-gray-100 p-2 sm:p-3 rounded shadow-md top-6 right-0 w-56 sm:w-64">
                            Refers to hands-off Copy Trading data from the past 12 months.
                        </div>
                    </div>
                </div>
                <a href="/about" class="text-blue-600 dark:text-blue-400 inline-flex items-center mb-4 hover:underline text-sm sm:text-base">
                    Explore Bullsbybit Statistics
                    {{-- Adjusted arrow icon size: w-3 h-3 ml-1 (for sm), w-4 h-4 ml-2 (for md) --}}
                    <img src="https://cdn.sanity.io/images/uswo7bx0/production/ee4682395fddf7d9b8827665f7a3aacf0cfe3bea-52x56.png?auto=format"
                         alt="Arrow" class="ml-1 w-3 h-3 sm:ml-2 sm:w-4 sm:h-4">
                </a>
                <a href="/register"
                   class="inline-block px-4 py-2 sm:px-5 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition text-sm sm:text-base">
                    Try it Yourself
                </a>
            </div>
        </div>

        {{-- Section 3 --}}
        <div class="flex flex-col lg:flex-row items-center gap-6 md:gap-8">
            {{-- Image hidden on small screens too (hidden md:block) --}}
            <div class="w-full lg:w-1/2">
                {{-- Adjusted image size: h-48 sm:h-auto (on small screens, max height will be 48, then auto) --}}
                <img src="https://cdn.sanity.io/images/uswo7bx0/production/54847a4abb8484536b018ad3dfb9f142e7f30e1b-403x321.png?auto=format"
                     alt="Why Bullsbybit?" class="mx-auto h-48 sm:h-auto" height="350">
            </div>
            <div class="w-full lg:w-1/2 px-4 sm:px-0"> {{-- Added px-4 for internal padding on small screens --}}
                {{-- Adjusted text sizes: text-xl md:text-3xl (h2), text-sm md:text-base (li) --}}
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 md:mb-6">Why Bullsbybit?</h2>
                <ul class="list-decimal list-inside space-y-1 md:space-y-2 text-left text-sm sm:text-base">
                    <li><span class="font-semibold">Copy Trading at your Fingertips</span> – Copy experienced Leaders with ease.</li>
                    <li><span class="font-semibold">Multiple Assets</span> – Trade forex, crypto, stocks, and more.</li>
                    <li><span class="font-semibold">Integrated Brokers</span> – Open and manage accounts directly on the platform.</li>
                    <li><span class="font-semibold">Platform Agnostic</span> – Connect any MT4/MT5 or other broker accounts.</li>
                    <li><span class="font-semibold">Broker Agnostic</span> – Link any broker of your choice with flexibility.</li>
                </ul>
            </div>
        </div>

        {{-- Changed px-4 md:px-6 to px-0 sm:px-4 md:px-6 for no margin on small screens --}}
        <section class="pt-12 md:py-20 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
            <div class="max-w-7xl mx-auto px-0 sm:px-4 md:px-6">
                <div class="text-center mb-10">
                    {{-- Adjusted text size: text-xl md:text-4xl (h2) --}}
                    <h2 class="text-xl sm:text-2xl md:text-4xl font-extrabold">
                        <span class="text-indigo-600 dark:text-indigo-400">Benefit</span> From
                    </h2>
                </div>
                {{-- Adjusted grid columns for small screens: grid-cols-2 instead of grid-cols-1, and gap-4 for tighter spacing --}}
                {{-- Adjusted card padding: p-3 sm:p-6 for even smaller padding on smallest screens --}}
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 px-4 sm:px-0"> {{-- Changed grid-cols-1 to grid-cols-2 --}}
                    @php
                        $benefits = [
                            [
                                'title' => 'Transparent Platform',
                                'desc_sm' => 'All performance data is openly shared. No hidden fees.', // Shortened for small screens
                                'desc_lg' => 'Transparency is in our DNA. All performance data is shared openly with everyone! Plus, there are no hidden fees.',
                                'img' => 'https://cdn.sanity.io/images/uswo7bx0/production/3a74eb94ced3fab82c240c41bf3638dedbe87a17-101x101.png?auto=format'
                            ],
                            [
                                'title' => 'Advanced Tools',
                                'desc_sm' => 'Customize settings and trade with advanced tools.', // Shortened for small screens
                                'desc_lg' => 'If you prefer manual trading with Bullsbybit, you can always customize your settings and trade with various advanced tools.',
                                'img' => 'https://cdn.sanity.io/images/uswo7bx0/production/190ef23ced76088412bd215b6ade5b7f73282af4-101x101.png?auto=format'
                            ],
                            [
                                'title' => 'Innovative Solutions',
                                'desc_sm' => 'New features and optimized trading experience.', // Shortened for small screens
                                'desc_lg' => 'Our in-house team analyzes your needs to provide new features and optimize your trading experience.',
                                'img' => 'https://cdn.sanity.io/images/uswo7bx0/production/5aaacde1b4f10a0dd02b78a4fab33216a7b1badc-101x101.png?auto=format'
                            ],
                            [
                                'title' => 'Customer-Centric Culture',
                                'desc_sm' => 'Highly-rated Customer Service available via chat, phone, or email.', // Shortened for small screens
                                'desc_lg' => 'We are all here for you to improve your overall experience! Reach our highly-rated Customer Service from 3 am - 4 pm GMT via chat, phone or email.',
                                'img' => 'https://cdn.sanity.io/images/uswo7bx0/production/d55c23d580417b4c3ecae23716bbd7d6694a78bd-101x101.png?auto=format'
                            ],
                            [
                                'title' => 'Learning Environment',
                                'desc_sm' => 'Interact with leaders and fellow investors through social tools.', // Shortened for small screens
                                'desc_lg' => 'Leaders explain their trading strategy and answer investors’ questions. Our social tools let you interact with leaders and fellow investors.',
                                'img' => 'https://cdn.sanity.io/images/uswo7bx0/production/d86a4dadb9251cdad196646142b5b7f14e0ddda5-101x101.png?auto=format'
                            ],
                            [
                                'title' => 'Unique Advanced Features',
                                'desc_sm' => 'Discover Backtest, Watchlist, Risk-score, and ZuluGuard for informed decisions.', // Shortened for small screens
                                'desc_lg' => 'Discover Backtest, explore Watchlist, Risk-score and ZuluGuard. Make informed investing decisions and get control of your trade.',
                                'img' => 'https://cdn.sanity.io/images/uswo7bx0/production/1e114c51d25d014da63313f5345c71fbf5574f17-91x83.svg?auto=format'
                            ],
                        ];
                    @endphp

                    @foreach ($benefits as $benefit)
                        <div class="bg-white dark:bg-gray-800 p-3 sm:p-6 rounded-2xl shadow-md hover:shadow-lg transition duration-300"> {{-- Reduced p-4 to p-3 --}}
                            <div class="flex flex-col items-center text-center space-y-2 sm:space-y-4"> {{-- Reduced space-y-3 to space-y-2 --}}
                                {{-- Adjusted image size: w-12 h-12 sm:w-20 sm:h-20 --}}
                                <img src="{{ $benefit['img'] }}"
                                    alt="{{ $benefit['title'] }}"
                                    class="w-12 h-12 sm:w-20 sm:h-20 object-contain" {{-- Reduced w-16 h-16 to w-12 h-12 --}}
                                    loading="lazy" />
                                {{-- Adjusted text size: text-sm sm:text-lg (h4), text-xs (p) --}}
                                <h4 class="text-sm sm:text-lg font-bold">{{ $benefit['title'] }}</h4> {{-- Reduced text-base to text-sm --}}
                                {{-- Use different descriptions based on screen size --}}
                                <p class="text-xs text-gray-600 dark:text-gray-300 hidden sm:block">{{ $benefit['desc_lg'] }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-300 block sm:hidden">{{ $benefit['desc_sm'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        {{-- Section 4 --}}
        <section class="pt-12 md:py-20 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
            <div class="flex flex-col lg:flex-row items-center gap-6 md:gap-8">
            {{-- Image hidden on small screens too (hidden md:block) --}}
            <div class="w-full lg:w-1/2 hidden sm:block">
                {{-- Adjusted image size: h-48 sm:h-auto (on small screens, max height will be 48, then auto) --}}
                <img src="https://cdn.sanity.io/images/uswo7bx0/production/c32912aab3a0744936df36e6e7e54ce7724a13d0-480x383.webp?auto=format"
                     alt="How it works" class="mx-auto h-48 sm:h-auto" height="350">
            </div>
            <div class="w-full lg:w-1/2 px-4 sm:px-0"> {{-- Added px-4 for internal padding on small screens --}}
                {{-- Adjusted text sizes: text-xl md:text-3xl (h2), text-sm md:text-base (li, button) --}}
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 md:mb-6">How it works?</h2>
                <ul class="list-decimal list-inside space-y-1 md:space-y-2 text-left text-sm sm:text-base">
                    <li>Leaders join and share trading strategies.</li>
                    <li>Bullsbybit ranks Leaders based on performance and behavior.</li>
                    <li>Investors select Leaders to copy based on capital, risk, and goals.</li>
                </ul>
                <a href="/register"
                   class="inline-block mt-3 md:mt-4 px-4 py-2 sm:px-5 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition text-sm sm:text-base">
                    Create Account
                </a>
            </div>
        </div>
    </div>
</section>

<!--<section class="bg-white dark:bg-gray-900 pt-12 md:py-24">
    {{-- Changed px-4 md:px-6 to px-0 sm:px-4 md:px-6 for no margin on small screens --}}
    <div class="max-w-7xl mx-auto px-0 sm:px-4 md:px-6">
        {{-- Adjusted text size: text-xl md:text-4xl (h2) --}}
        <h2 class="text-xl sm:text-2xl md:text-4xl font-extrabold text-center text-gray-900 dark:text-white mb-8 md:mb-16">
            Our Top Performing Traders
        </h2>
        {{-- Adjusted card padding: p-4 sm:p-6 --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-12 px-4 sm:px-0"> {{-- Added px-4 for internal padding --}}
            @foreach ($topTraders as $trader)
            <div class="bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl shadow-lg p-4 sm:p-6 hover:scale-105 transform transition duration-300 cursor-pointer">
                <div class="flex flex-col items-center space-y-3 sm:space-y-4">
                    {{-- Adjusted avatar size: w-16 h-16 sm:w-20 sm:h-20 --}}
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden border-4 border-indigo-600">
                        <img src="{{ $trader->avatar_url }}" alt="{{ $trader->name }}" class="w-full h-full object-cover" loading="lazy" />
                    </div>
                    {{-- Adjusted text sizes: text-lg sm:text-xl (h3), text-base sm:text-lg (p), text-xs sm:text-sm (p), text-sm sm:text-base (a) --}}
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">{{ $trader->name }}</h3>
                    <p class="text-base sm:text-lg text-indigo-600 font-bold">+{{ $trader->monthly_return }}% Monthly Return</p>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Risk Level: {{ ucfirst($trader->risk_level) }}</p>
                    <a href="{{ route('guests.trader-profile', $trader->id) }}" class="mt-2 md:mt-4 inline-block text-indigo-700 hover:underline font-semibold text-sm sm:text-base">
                        View Profile
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>-->


<section class="bg-white-800 dark:bg-gray-800 text-white pt-12 pb-12 md:py-24 transition-colors duration-300">
    {{-- Changed px-4 md:px-6 to px-0 sm:px-4 md:px-6 for no margin on small screens --}}
    <div class="max-w-3xl mx-auto text-center space-y-6 md:space-y-8 px-0 sm:px-4 md:px-6">
        {{-- Adjusted text sizes: text-xl md:text-4xl (h2), text-sm md:text-lg (p), text-sm md:text-base (button) --}}
        <h2 class="text-xl sm:text-2xl md:text-4xl font-extrabold leading-tight drop-shadow-lg">
            Ready to start your crypto journey with Bullsbybit?
        </h2>   
        <p class="text-sm text-indigo-600 dark:<section class="pt-12 md:py-20 bg-white dark:bg-gray-900 text-gray-900 dark:text-white sm:text-base md:text-lg max-w-xl mx-auto">
            Sign up today and get exclusive access to top traders and automated portfolio growth.
        </p>
        <a href="{{ route('register') }}"
           class="inline-block bg-white dark:bg-gray-100 text-indigo-900 dark:text-indigo-800 font-bold px-6 py-3 md:px-10 md:py-5 rounded-lg shadow-lg hover:bg-indigo-50 dark:hover:bg-gray-200 transition text-sm sm:text-base">
            Create Your Account Now
        </a>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const video = document.getElementById('heroVideo');
        if(video) {
            video.playbackRate = 0.5; // reduce speed by 50%
        }
    });
</script>
</x-layouts.guest>



<!-- TESTIMONIALS -->
<!--<section class="bg-indigo-50 dark:bg-gray-900 pt-12 md:py-24">
    <div class="max-w-4xl mx-auto px-4 md:px-6 text-center space-y-8 md:space-y-12">
        <h2 class="text-2xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
            What Our Users Say
        </h2>
        <div class="grid md:grid-cols-3 gap-6 md:gap-12">
            <article class="bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-lg flex flex-col items-center space-y-4 md:space-y-6">
                <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="User 1" class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover border-4 border-indigo-600"/>
                <p class="italic text-gray-600 dark:text-gray-300 max-w-xs text-sm md:text-base">"Entrade transformed the way I manage my crypto investments. Copy trading is seamless and profitable!"</p>
                <strong class="text-indigo-700 font-semibold text-sm md:text-base">Sarah M.</strong>
            </article>
            <article class="bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-lg flex flex-col items-center space-y-4 md:space-y-6">
                <img src="https://randomuser.me/api/portraits/men/72.jpg" alt="User 2" class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover border-4 border-indigo-600"/>
                <p class="italic text-gray-600 dark:text-gray-300 max-w-xs text-sm md:text-base">"I trust Entrade's verified traders. The dashboard gives me all the info I need to make smart decisions."</p>
                <strong class="text-indigo-700 font-semibold text-sm md:text-base">James K.</strong>
            </article>
            <article class="bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-lg flex flex-col items-center space-y-4 md:space-y-6">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User 3" class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover border-4 border-indigo-600"/>
                <p class="italic text-gray-600 dark:text-gray-300 max-w-xs text-sm md:text-base">"The copy trading automation has saved me so much time and stress."</p>
                <strong class="text-indigo-700 font-semibold text-sm md:text-base">Anna L.</strong>
            </article>
        </div>
    </div>
</section>-->

<!--OUR AWARDS-->
<!--<section class="bg-white dark:bg-gray-900 pt-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">-->
        <!-- Section Heading -->
        <!--<div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl md:text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white">
                Our <span class="text-secondary">Awards</span>
            </h2>
        </div>-->

        <!-- Awards Grid -->
        <!--<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            @php
                $awards = [
                    ['badge' => '🏆', 'title' => 'Best Social Trading Solution MEA', 'details' => ['UF AWARDS', 'MEA', 'DUBAI, 2024']],
                    ['badge' => '🥇', 'title' => 'Best Social Trading Solution', 'details' => ['UF AWARDS', 'GLOBAL', 'CYPRUS, 2023']],
                    ['badge' => '🌏', 'title' => 'Best Social Trading Solution APAC', 'details' => ['UF AWARDS', 'BANGKOK, 2023']],
                    ['badge' => '💼', 'title' => 'Best Wealth Management Platform', 'details' => ['FAME AWARD', 'SA, 2023']],
                    ['badge' => '🏆', 'title' => 'Best Social Trading Solution MEA', 'details' => ['UF AWARDS', 'DUBAI, 2023']],
                    ['badge' => '🥇', 'title' => 'Best Social Trading Solution', 'details' => ['UF AWARDS', 'CYPRUS, 2022']],
                    ['badge' => '💹', 'title' => 'Best Social Wealth Management Platform', 'details' => ['FOREX EXPO', 'DUBAI, 2022']],
                ];
            @endphp

            @foreach ($awards as $award)
                <div class="group bg-gray-50 dark:bg-gray-800 p-4 md:p-6 rounded-xl md:rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 text-center">-->
                    <!-- Badge/Icon -->
                    <!--<div class="text-4xl md:text-5xl mb-3 md:mb-4 transition-transform duration-300 group-hover:scale-110">
                        {{ $award['badge'] }}
                    </div>-->

                    <!-- Award Details -->
                    <!--<div class="text-xs md:text-sm font-semibold text-gray-700 dark:text-gray-300 space-y-1 mb-2 md:mb-3">
                        @foreach ($award['details'] as $line)
                            <p>{{ $line }}</p>
                        @endforeach
                    </div>-->

                    <!-- Award Title -->
                    <!--<h6 class="text-sm md:text-base font-medium text-gray-900 dark:text-white">
                        {{ $award['title'] }}
                    </h6>
                </div>
            @endforeach
        </div>
    </div>
</section>-->