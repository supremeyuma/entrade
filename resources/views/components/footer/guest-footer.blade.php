<footer class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 mt-12">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Branding -->
        <div>
            <h2 class="text-xl font-bold mb-4">Entrade</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Smarter copy trading. Track top traders, copy strategies, and grow your portfolio—effortlessly.</p>
        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Explore</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">Home</a></li>
                <li><a href="{{ url('/about') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">About</a></li>
                <li><a href="{{ url('/faq') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">Help Center</a></li>
                <li><a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">Login</a></li>
            </ul>
        </div>

        <!--Legal & Privacy (optional) -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Legal</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">Terms of Service</a></li>
                <li><a href="{{ url('/about') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">Privacy Policy</a></li>
                <li><a href="{{ url('/faq') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">Cookies Policy</a></li>
                <li><a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">Risk Disclaimer</a></li>
            </ul>
        </div>

        <!-- App Downloads (optional) -->
        <!--<div>
            <h3 class="text-lg font-semibold mb-3">Get the App</h3>
            <div class="flex flex-col space-y-2">
                <a href="#" class="block">
                    <img src="{{ asset('images/appstore-badge.svg') }}" alt="Download on the App Store" class="h-10">
                </a>
                <a href="#" class="block">
                    <img src="{{ asset('images/playstore-badge.svg') }}" alt="Get it on Google Play" class="h-10">
                </a>
            </div>
        </div>-->

        <!-- Social Media (optional) -->
        <!--<div>
            <h3 class="text-lg font-semibold mb-3">Connect</h3>
            <div class="flex space-x-4 mt-2">
                <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.46 6c-.77.35-1.6.59-2.46.69a4.3 4.3 0 001.89-2.37 8.55 8.55 0 01-2.7 1.03 4.27 4.27 0 00-7.3 3.89A12.12 12.12 0 013 4.8a4.27 4.27 0 001.32 5.7A4.22 4.22 0 012.8 9.7v.05a4.27 4.27 0 003.42 4.19 4.3 4.3 0 01-1.93.07 4.27 4.27 0 003.98 2.96A8.57 8.57 0 012 19.54a12.09 12.09 0 006.56 1.92c7.87 0 12.18-6.52 12.18-12.17 0-.19 0-.37-.01-.56A8.72 8.72 0 0024 5.1a8.58 8.58 0 01-2.54.7z"/>
                    </svg>
                </a>
                <!-- Add more icons as needed -->
            </div>
        </div>-->
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700 text-center py-4 text-sm text-gray-500 dark:text-gray-400">
        © {{ now()->year }} Entrade. All rights reserved.
    </div>
</footer>
