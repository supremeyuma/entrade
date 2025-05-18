@extends('layouts.guest')

@section('content')
<div x-data="videoSlider()" x-init="start()" class="relative w-full h-[80vh] overflow-hidden">

    <!-- Video Slides -->
    <template x-for="(video, index) in videos" :key="index">
        <video
            x-show="current === index"
            x-transition:enter="transition-opacity duration-1000"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-1000"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute top-0 left-0 w-full h-full object-cover"
            :src="video"
            autoplay
            muted
            loop
        ></video>
    </template>

    <!-- Overlay Content -->
    <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white px-6">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow">Copy the Best Traders, Instantly</h1>
        <p class="text-lg md:text-xl mb-6 max-w-2xl drop-shadow">Join Entrade and follow top-performing crypto traders. No expertise required.</p>
        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-lg text-white font-semibold shadow-lg transition">Get Started</a>
    </div>

</div>

<!-- Section 2: How It Works -->
<section class="bg-white dark:bg-gray-800 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 dark:text-white mb-12">
            How Copy Trading Works
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <!-- Step 1 -->
            <div class="flex flex-col items-center">
                <div class="bg-indigo-100 dark:bg-indigo-900 p-4 rounded-full mb-4">
                    <svg class="w-10 h-10 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Create an Account</h3>
                <p class="text-gray-600 dark:text-gray-300">Sign up in minutes. It's fast, secure, and free to get started.</p>
            </div>

            <!-- Step 2 -->
            <div class="flex flex-col items-center">
                <div class="bg-indigo-100 dark:bg-indigo-900 p-4 rounded-full mb-4">
                    <svg class="w-10 h-10 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Choose a Top Trader</h3>
                <p class="text-gray-600 dark:text-gray-300">Browse the leaderboard and pick a trader whose strategy fits you.</p>
            </div>

            <!-- Step 3 -->
            <div class="flex flex-col items-center">
                <div class="bg-indigo-100 dark:bg-indigo-900 p-4 rounded-full mb-4">
                    <svg class="w-10 h-10 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h4l3 10h8l3-10h4" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Invest & Earn</h3>
                <p class="text-gray-600 dark:text-gray-300">Your funds automatically follow your selected trader’s performance.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 3: Top Traders Preview -->
<section class="bg-gray-50 dark:bg-gray-900 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 dark:text-white mb-12">
            Meet Our Top Traders
        </h2>

        <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
            @foreach ([1, 2, 3] as $trader)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 text-center">
                    <img src="https://via.placeholder.com/100" alt="Trader {{ $trader }}" class="mx-auto mb-4 rounded-full border-4 border-indigo-500 w-24 h-24 object-cover">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-1">Trader {{ $trader }}</h3>
                    <p class="text-gray-500 dark:text-gray-300 mb-2">+{{ rand(8, 25) }}% Avg Monthly Return</p>
                    <p class="text-sm text-gray-400 dark:text-gray-400">Risk Level: {{ ['Low', 'Medium', 'High'][($trader - 1) % 3] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('leaderboard.public') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-xl transition">
                View All Traders
            </a>
        </div>
    </div>
</section>

<!-- Section 4: Why Choose Entrade -->
<section class="bg-white dark:bg-gray-800 py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-12">
            Why Choose Entrade?
        </h2>

        <div class="grid gap-10 grid-cols-1 md:grid-cols-3 text-left">
            <!-- Feature 1 -->
            <div class="flex items-start space-x-4">
                <div class="bg-indigo-100 dark:bg-indigo-900 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Simple & Intuitive</h4>
                    <p class="text-gray-600 dark:text-gray-300">Start investing in just a few clicks with our easy-to-use interface.</p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="flex items-start space-x-4">
                <div class="bg-indigo-100 dark:bg-indigo-900 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Verified Traders</h4>
                    <p class="text-gray-600 dark:text-gray-300">All traders go through a vetting process for performance and safety.</p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="flex items-start space-x-4">
                <div class="bg-indigo-100 dark:bg-indigo-900 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 10h4l3 10h8l3-10h4" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Real Returns</h4>
                    <p class="text-gray-600 dark:text-gray-300">Earn based on actual trading performance — no fluff, just facts.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Section 5: Testimonials -->
<section class="bg-gray-50 dark:bg-gray-900 py-16">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-12">
            What Our Users Say
        </h2>

        <div class="grid gap-8 grid-cols-1 md:grid-cols-2">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
                <p class="text-gray-700 dark:text-gray-300 italic mb-4">"Entrade made investing easy for me. I picked a trader, and my account started growing."</p>
                <h4 class="font-semibold text-gray-800 dark:text-white">— Sarah L.</h4>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
                <p class="text-gray-700 dark:text-gray-300 italic mb-4">"As a beginner, I was nervous. But now I'm seeing consistent returns without doing the trading myself."</p>
                <h4 class="font-semibold text-gray-800 dark:text-white">— Ahmed R.</h4>
            </div>
        </div>
    </div>
</section>

<!-- Section 6: Call to Action -->
<section class="bg-indigo-600 py-16 text-center text-white">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Copy Trading?</h2>
        <p class="text-lg mb-8">Create your account today and let top traders work for you.</p>
        <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-600 font-semibold px-6 py-3 rounded-xl hover:bg-gray-100 transition">
            Get Started
        </a>
    </div>
</section>

<!-- Section 7: Footer -->
<footer class="bg-gray-900 text-gray-300 py-12">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Logo and Tagline -->
        <div>
            <h3 class="text-2xl font-bold text-white mb-2">Entrade</h3>
            <p>Empowering everyday investors with the power of top traders.</p>
        </div>

        <!-- Quick Links -->
        <div>
            <h4 class="text-lg font-semibold text-white mb-3">Quick Links</h4>
            <ul class="space-y-2">
                <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
                <li><a href="{{ route('leaderboard.public') }}" class="hover:underline">Top Traders</a></li>
                <li><a href="{{ route('about') }}" class="hover:underline">About</a></li>
                <li><a href="{{ route('faq') }}" class="hover:underline">FAQ</a></li>
            </ul>
        </div>

        <!-- Legal -->
        <div>
            <h4 class="text-lg font-semibold text-white mb-3">Legal</h4>
            <ul class="space-y-2">
                <li><a href="#" class="hover:underline">Terms of Service</a></li>
                <li><a href="#" class="hover:underline">Privacy Policy</a></li>
            </ul>
        </div>

        <!-- Contact / Social -->
        <div>
            <h4 class="text-lg font-semibold text-white mb-3">Connect</h4>
            <ul class="space-y-2">
                <li>Email: <a href="mailto:support@entrade.com" class="hover:underline">support@entrade.com</a></li>
                <li>Twitter: <a href="#" class="hover:underline">@Entrade</a></li>
                <li>LinkedIn: <a href="#" class="hover:underline">Entrade CopyTrading</a></li>
            </ul>
        </div>
    </div>

    <div class="text-center text-sm text-gray-500 mt-10">
        &copy; {{ now()->year }} Entrade. All rights reserved.
    </div>
</footer>



<!-- Alpine.js video slider component -->
<script>
    function videoSlider() {
        return {
            current: 0,
            interval: null,
            videos: [
                'https://videos.pexels.com/video-files/14610894/14610894-uhd_2560_1440_24fps.mp4',
                'https://videos.pexels.com/video-files/14610894/14610894-uhd_2560_1440_24fps.mp4',
            ],
            start() {
                this.interval = setInterval(() => {
                    this.current = (this.current + 1) % this.videos.length;
                }, 10000); // Change every 10 seconds
            }
        }
    }
</script>
@endsection
