<footer class="bg-gray-900 text-white py-10">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        <!-- Logo and App Promotion -->
        <div class="flex flex-col justify-between space-y-6">
            <!-- Logo -->
            <div>
                <img src="{{ asset('images/logo-light.svg') }}" class="block dark:hidden w-44 mb-4" alt="Entrade Logo">
                <img src="{{ asset('images/logo-dark.svg') }}" class="hidden dark:block w-44 mb-4" alt="Entrade Logo">
                <p class="text-lg font-medium">Copytrade with <span class="text-primary font-semibold">Entrade</span></p>
            </div>

            <!-- App Download -->
            <div>
                <p class="text-sm text-gray-400 mb-1">Download app for</p>
                <div class="flex items-center gap-4">
                    <a href="#" target="_blank" class="flex items-center gap-2 bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded">
                        <img src="{{ asset('images/appstore-ios.png') }}" alt="iOS" class="w-5 h-5">
                        <span class="text-sm font-medium">iOS</span>
                    </a>
                    <a href="#" target="_blank" class="flex items-center gap-2 bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded">
                        <img src="{{ asset('images/appstore-android.png') }}" alt="Android" class="w-5 h-5">
                        <span class="text-sm font-medium">Android</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- App Image (optional for larger screens) -->
        <div class="hidden xl:block">
            <img src="{{ asset('images/footer-app-preview.png') }}" alt="Mobile App" class="w-32 mx-auto">
        </div>

        <!-- Social Links -->
        <div class="mt-6 xl:mt-0">
            <p class="text-base mb-3 font-semibold">Follow us on</p>
            <div class="flex space-x-4 text-white text-xl">
                <a href="https://facebook.com" target="_blank" class="hover:text-blue-500">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com" target="_blank" class="hover:text-sky-400">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://linkedin.com" target="_blank" class="hover:text-blue-300">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://youtube.com" target="_blank" class="hover:text-red-600">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="hover:text-pink-500">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://tiktok.com" target="_blank" class="hover:text-black dark:hover:text-white">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
