<footer class="bg-gray-900 text-white mt-12">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Branding -->
        <div>
            <h2 class="text-xl font-bold mb-4">Entrade</h2>
            <p class="text-sm text-gray-400">Smarter copy trading. Track top traders, copy strategies, and grow your portfolio—effortlessly.</p>
        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Explore</h3>
            <ul class="space-y-2 text-sm text-gray-300">
                <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-white">About</a></li>
                <li><a href="{{ route('faq') }}" class="hover:text-white">FAQ</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
            </ul>
        </div>

        <!-- App Downloads -->
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

        <!-- Social Media -->
        <!--<div>
            <h3 class="text-lg font-semibold mb-3">Connect</h3>
            <div class="flex space-x-4 mt-2">
                <a href="#" class="text-gray-400 hover:text-white">
                    < class="w-6 h-6" />
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    < class="w-6 h-6" />
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <class="w-6 h-6" />
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    < class="w-6 h-6" />
                </a>
            </div>
        </div>
    </div>-->

    <div class="border-t border-gray-800 text-center py-4 text-sm text-gray-500">
        © {{ now()->year }} Entrade. All rights reserved.
    </div>
</footer>
