@extends('layouts.guest')

@section('content')

<!-- HERO SECTION -->
<section class="py-16 px-6 bg-white dark:bg-gray-800 transition-colors duration-500">
  <!-- Text Above Video -->
  <div class="max-w-4xl mx-auto text-center mb-12">
    <h1 class="text-4xl font-extrabold leading-tight mb-4 text-gray-900 dark:text-white">
      Effortless Copy Trading
    </h1>
    <p class="text-gray-700 dark:text-indigo-300 text-lg max-w-2xl mx-auto">
      Powered by Verified Crypto Traders — grow your crypto portfolio with confidence by copying top traders.
    </p>
  </div>

  <!-- Video centered -->
  <div class="max-w-5xl mx-auto">
    <video id="heroVideo"
           class="w-full h-auto max-w-full rounded-lg shadow-lg mx-auto"
           autoplay muted playsinline preload="auto" 
           src="https://cdn.sanity.io/files/uswo7bx0/production/97783b225d2d81433828edb874e0f030f3f96f52.mp4"
           type="video/mp4"
           ></video>
  </div>

  <!-- Text Below Video -->
  <div class="max-w-4xl mx-auto text-center mt-12">
    <p class="text-gray-700 dark:text-indigo-300 text-lg max-w-2xl mx-auto">
      Track performance, control risk, and automate your investments on a transparent platform.
    </p>
    <div class="flex justify-center gap-6 mt-8">
      <a href="{{ route('register') }}" 
         class="bg-indigo-700 dark:bg-indigo-300 dark:text-indigo-900 text-white font-bold px-8 py-4 rounded-lg shadow-lg hover:bg-indigo-600 dark:hover:bg-indigo-400 transition">
        Get Started Free
      </a>
      <a href="{{ route('leaderboard.public') }}" 
         class="border border-indigo-700 dark:border-indigo-300 hover:bg-indigo-700 dark:hover:bg-indigo-300 hover:text-white dark:hover:text-indigo-900 px-8 py-4 rounded-lg font-semibold transition">
        Explore Top Traders
      </a>
    </div>

    <!-- Stats Section -->
    <div class="flex flex-wrap justify-center gap-12 mt-12">
      <div class="flex flex-col items-center text-gray-900 dark:text-white">
        <span class="text-3xl font-extrabold">100K+</span>
        <span class="text-sm">Users Worldwide</span>
      </div>
      <div class="flex flex-col items-center text-gray-900 dark:text-white">
        <span class="text-3xl font-extrabold">250+</span>
        <span class="text-sm">Verified Traders</span>
      </div>
      <div class="flex flex-col items-center text-gray-900 dark:text-white">
        <span class="text-3xl font-extrabold">50M+</span>
        <span class="text-sm">Assets Managed</span>
      </div>
    </div>
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

<!--TRADING IS HARD-->
<!--<section class="max-w-4xl mx-auto px-6 py-24">
    <h2 class="text-4xl font-extrabold text-center text-gray-900 dark:text-white mb-16">
        Trading Is Hard
    </h2>
    <p class="text-gray-700 dark:text-indigo-300 text-center max-w-2xl mx-auto">
        Copy trading is a powerful tool for growing your crypto portfolio, but it requires careful planning and execution. In this section, we'll explore the key concepts and strategies behind copy trading, and provide some tips and tricks to help you get started.
    </p>
    <div class="grid md:grid-cols-3 gap-16">
        <article class="space-y-6 flex flex-col items-center text-center">
            <div class="bg-indigo-600 rounded-full p-6 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Understand the Basics</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                Before you start copy trading, it's important to understand the basics of cryptocurrency trading. Learn about the different types of cryptocurrencies, market trends, and how to trade them effectively.
            </p>
        </article>
        <article class="space-y-6 flex flex-col items-center text-center">
            <div class="bg-indigo-600 rounded-full p-6 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Choose a Trading Strategy</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                There are many different trading strategies to choose from, such as mean reversion, momentum, and trend following. Choose the one that works best for you and your risk tolerance.
            </p>
        </article>
        <article class="space-y-6 flex flex-col items-center text-center">
            <div class="bg-indigo-600 rounded-full p-6 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Set a Trading Plan</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                Develop a trading plan that outlines your goals, risk tolerance, and trading frequency. This will help you stay focused and motivated throughout your trading journey.
            </p>
        </article>
    </div>
</section>-->

<section class="py-16 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
    <div class="container mx-auto px-4 space-y-20">
        {{-- Section 1 --}}
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <div class="w-full lg:w-1/2">
                <img src="https://cdn.sanity.io/images/uswo7bx0/production/4a499068f6fce07021829be6a1f3a2612501afd7-426x327.webp?auto=format"
                     alt="Trading is hard"
                     class="mx-auto" height="350">
            </div>
            <div class="w-full lg:w-1/2">
                <h2 class="text-3xl font-bold mb-4">Truth is... <br> Trading is not easy</h2>
                <div class="mb-3 flex items-center">
                    <img src="https://cdn.sanity.io/images/uswo7bx0/production/2fd3ca4ccb56a3d567a86c2f73c10722889e8c72-383x383.svg?auto=format"
                         alt="Clock icon" class="w-5 h-5 mr-2">
                    <span>Studying the market takes time</span>
                </div>
                <div class="mb-3 flex items-center">
                    <img src="https://cdn.sanity.io/images/uswo7bx0/production/0a26a0aa4b88a029244bf62419d3d15e00b501a4-382x383.svg?auto=format"
                         alt="Building icon" class="w-5 h-5 mr-2">
                    <span>Building and maintaining a trading strategy is hard</span>
                </div>
                <div class="mb-4 flex items-start">
                    <p>That’s why only <strong>11-26% of manual investors</strong> end up winning.</p>
                    <div class="relative group ml-2 cursor-pointer">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <div class="absolute z-10 hidden group-hover:block bg-gray-200 dark:bg-gray-800 text-sm text-gray-800 dark:text-gray-100 p-3 rounded shadow-md top-6 left-0 w-64">
                            "Between 74-89% of retail investor accounts lose money when trading CFDs." (source: <span class="font-semibold">ESMA</span>)
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2 --}}
        <div class="flex flex-col lg:flex-row-reverse items-center gap-8">
            <div class="w-full lg:w-1/2">
                <img src="https://cdn.sanity.io/images/uswo7bx0/production/cdbbacb2e17b1b0066398ab12312952b056309f3-352x414.webp?auto=format"
                     alt="Copy trading benefits" class="mx-auto" height="350">
            </div>
            <div class="w-full lg:w-1/2 text-right lg:text-right">
                <h2 class="text-3xl font-bold mb-4">Beat the odds with Copy Trading</h2>
                <div class="mb-4 flex justify-end items-start">
                    <p class="text-left">Did you know that <strong>73% of our investors make profit</strong> when copying top leaders correctly?</p>
                    <div class="relative group ml-2 cursor-pointer">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <div class="absolute z-10 hidden group-hover:block bg-gray-200 dark:bg-gray-800 text-sm text-gray-800 dark:text-gray-100 p-3 rounded shadow-md top-6 right-0 w-64">
                            Refers to hands-off Copy Trading data from the past 12 months.
                        </div>
                    </div>
                </div>
                <a href="/zulutrade-data" class="text-blue-600 dark:text-blue-400 inline-flex items-center mb-4 hover:underline">
                    Explore ZuluTrade’s Statistics
                    <img src="https://cdn.sanity.io/images/uswo7bx0/production/ee4682395fddf7d9b8827665f7a3aacf0cfe3bea-52x56.png?auto=format"
                         alt="Arrow" class="ml-2 w-4 h-4">
                </a>
                <a href="/register"
                   class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition">
                    Try it Yourself
                </a>
            </div>
        </div>

        {{-- Section 3 --}}
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <div class="w-full lg:w-1/2">
                <img src="https://cdn.sanity.io/images/uswo7bx0/production/54847a4abb8484536b018ad3dfb9f142e7f30e1b-403x321.png?auto=format"
                     alt="Why ZuluTrade?" class="mx-auto" height="350">
            </div>
            <div class="w-full lg:w-1/2">
                <h2 class="text-3xl font-bold mb-6">Why ZuluTrade?</h2>
                <ul class="list-decimal list-inside space-y-2 text-left">
                    <li><span class="font-semibold">Copy Trading at your Fingertips</span> – Copy experienced Leaders with ease.</li>
                    <li><span class="font-semibold">Multiple Assets</span> – Trade forex, crypto, stocks, and more.</li>
                    <li><span class="font-semibold">Integrated Brokers</span> – Open and manage accounts directly on the platform.</li>
                    <li><span class="font-semibold">Platform Agnostic</span> – Connect any MT4/MT5 or other broker accounts.</li>
                    <li><span class="font-semibold">Broker Agnostic</span> – Link any broker of your choice with flexibility.</li>
                </ul>
            </div>
        </div>

        {{-- Section 4 --}}
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <div class="w-full lg:w-1/2">
                <img src="https://cdn.sanity.io/images/uswo7bx0/production/c32912aab3a0744936df36e6e7e54ce7724a13d0-480x383.webp?auto=format"
                     alt="How it works" class="mx-auto" height="350">
            </div>
            <div class="w-full lg:w-1/2">
                <h2 class="text-3xl font-bold mb-6">How it works?</h2>
                <ul class="list-decimal list-inside space-y-2 text-left">
                    <li>Leaders join and share trading strategies.</li>
                    <li>ZuluTrade ranks Leaders based on performance and behavior.</li>
                    <li>Investors select Leaders to copy based on capital, risk, and goals.</li>
                </ul>
                <a href="/register"
                   class="inline-block mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition">
                    Create Account
                </a>
            </div>
        </div>
    </div>
</section>


<!-- HOW IT WORKS -->
<!--<section class="max-w-7xl mx-auto px-6 py-24">
    <h2 class="text-4xl font-extrabold text-center text-gray-900 dark:text-white mb-16">
        How Copy Trading Works
    </h2>
    <div class="grid md:grid-cols-3 gap-16">
        <article class="space-y-6 flex flex-col items-center text-center">
            <div class="bg-indigo-600 rounded-full p-6 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Sign Up & Deposit Funds</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                Create your account, securely deposit your funds using our trusted crypto gateway, and prepare to copy.
            </p>
        </article>
        <article class="space-y-6 flex flex-col items-center text-center">
            <div class="bg-indigo-600 rounded-full p-6 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Choose Verified Traders</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                Browse detailed trader profiles, analyze past performance, and pick the ones matching your risk and goals.
            </p>
        </article>
        <article class="space-y-6 flex flex-col items-center text-center">
            <div class="bg-indigo-600 rounded-full p-6 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 10h4l3 10h8l3-10h4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Automate Your Investments</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                Once connected, your funds will automatically follow your chosen traders' live positions and returns.
            </p>
        </article>
    </div>
</section>-->

<!-- FEATURED TRADERS -->
<section class="bg-indigo-50 dark:bg-gray-900 py-24">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-extrabold text-center text-gray-900 dark:text-white mb-16">
            Our Top Performing Traders
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            @foreach ($topTraders as $trader)
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg p-8 hover:scale-105 transform transition duration-300 cursor-pointer">
                <div class="flex flex-col items-center space-y-6">
                    <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-indigo-600">
                        <img src="{{ $trader->avatar_url }}" alt="{{ $trader->name }}" class="w-full h-full object-cover" loading="lazy" />
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $trader->name }}</h3>
                    <p class="text-indigo-600 font-bold text-xl">+{{ $trader->monthly_return }}% Monthly Return</p>
                    <p class="text-gray-500 dark:text-gray-400">Risk Level: {{ ucfirst($trader->risk_level) }}</p>
                    <a href="{{ route('guests.trader-profile', $trader->id) }}" class="mt-4 inline-block text-indigo-700 hover:underline font-semibold">
                        View Profile
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="max-w-7xl mx-auto px-6 py-24">
    <h2 class="text-4xl font-extrabold text-center text-gray-900 dark:text-white mb-16">
        Why Choose Entrade?
    </h2>
    <div class="grid md:grid-cols-3 gap-12">
        <div class="flex flex-col items-center text-center space-y-6 px-6 py-10 rounded-3xl border border-indigo-200 dark:border-indigo-700 shadow-lg hover:shadow-xl transition">
            <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" >
                <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Trusted & Verified Traders</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                Each trader is vetted thoroughly to ensure the highest standards of reliability and performance.
            </p>
        </div>
        <div class="flex flex-col items-center text-center space-y-6 px-6 py-10 rounded-3xl border border-indigo-200 dark:border-indigo-700 shadow-lg hover:shadow-xl transition">
            <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" >
                <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 8v4l3 3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Secure & Transparent</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                Your funds and trades are protected with industry-leading encryption and full transparency.
            </p>
        </div>
        <div class="flex flex-col items-center text-center space-y-6 px-6 py-10 rounded-3xl border border-indigo-200 dark:border-indigo-700 shadow-lg hover:shadow-xl transition">
            <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" >
                <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Easy to Use Platform</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                Intuitive interface to start copy trading instantly without a steep learning curve.
            </p>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="bg-indigo-50 dark:bg-gray-900 py-24">
    <div class="max-w-4xl mx-auto px-6 text-center space-y-12">
        <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">
            What Our Users Say
        </h2>
        <div class="grid md:grid-cols-3 gap-12">
            <article class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-lg flex flex-col items-center space-y-6">
                <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="User 1" class="w-20 h-20 rounded-full object-cover border-4 border-indigo-600"/>
                <p class="italic text-gray-600 dark:text-gray-300 max-w-xs">"Entrade transformed the way I manage my crypto investments. Copy trading is seamless and profitable!"</p>
                <strong class="text-indigo-700 font-semibold">Sarah M.</strong>
            </article>
            <article class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-lg flex flex-col items-center space-y-6">
                <img src="https://randomuser.me/api/portraits/men/72.jpg" alt="User 2" class="w-20 h-20 rounded-full object-cover border-4 border-indigo-600"/>
                <p class="italic text-gray-600 dark:text-gray-300 max-w-xs">"I trust Entrade’s verified traders. The dashboard gives me all the info I need to make smart decisions."</p>
                <strong class="text-indigo-700 font-semibold">James K.</strong>
            </article>
            <article class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-lg flex flex-col items-center space-y-6">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User 3" class="w-20 h-20 rounded-full object-cover border-4 border-indigo-600"/>
                <p class="italic text-gray-600 dark:text-gray-300 max-w-xs">"The copy trading automation has saved me so much time and stress."</p>
                <strong class="text-indigo-700 font-semibold">Anna L.</strong>
            </article>
        </div>
    </div>
</section>

<!--OUR AWARDS-->
<section class="bg-white dark:bg-gray-900 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Heading -->
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white">
                Our <span class="text-secondary">Awards</span>
            </h2>
        </div>

        <!-- Awards Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-8">
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
                <div class="group bg-gray-50 dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 text-center">
                    <!-- Badge/Icon -->
                    <div class="text-5xl mb-4 transition-transform duration-300 group-hover:scale-110">
                        {{ $award['badge'] }}
                    </div>

                    <!-- Award Details -->
                    <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 space-y-1 mb-3">
                        @foreach ($award['details'] as $line)
                            <p>{{ $line }}</p>
                        @endforeach
                    </div>

                    <!-- Award Title -->
                    <h6 class="text-base font-medium text-gray-900 dark:text-white">
                        {{ $award['title'] }}
                    </h6>
                </div>
            @endforeach
        </div>
    </div>
</section>



<!-- CALL TO ACTION -->
<section class="bg-indigo-700 text-white py-24">
    <div class="max-w-3xl mx-auto text-center space-y-8 px-6">
        <h2 class="text-4xl font-extrabold leading-tight drop-shadow-lg">
            Ready to start your crypto journey with Entrade?
        </h2>
        <p class="text-indigo-300 text-lg max-w-xl mx-auto">
            Sign up today and get exclusive access to top traders and automated portfolio growth.
        </p>
        <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-900 font-bold px-10 py-5 rounded-lg shadow-lg hover:bg-indigo-50 transition">
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

@endsection
