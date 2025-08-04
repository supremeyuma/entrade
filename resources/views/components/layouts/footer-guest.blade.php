<footer class="bg-gray-900 text-gray-300 text-sm">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-2 md:grid-cols-4 gap-8">
        <!-- Products -->
        <div>
            <h3 class="text-white font-semibold mb-4">Products</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:underline">Copy Trading</a></li>
                <li><a href="#" class="hover:underline">Market Insights</a></li>
                <li><a href="#" class="hover:underline">Traders</a></li>
                <li><a href="#" class="hover:underline">Affiliate Program</a></li>
            </ul>
        </div>

        <!-- Company -->
        <div>
            <h3 class="text-white font-semibold mb-4">Company</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:underline">About Entrade</a></li>
                <li><a href="#" class="hover:underline">Careers</a></li>
                <li><a href="#" class="hover:underline">Blog</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </div>

        <!-- Legal -->
        <div>
            <h3 class="text-white font-semibold mb-4">Legal</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:underline">Terms of Service</a></li>
                <li><a href="#" class="hover:underline">Privacy Policy</a></li>
                <li><a href="#" class="hover:underline">Risk Disclosure</a></li>
                <li><a href="#" class="hover:underline">Cookies Policy</a></li>
            </ul>
        </div>

        <!-- Connect -->
        <div>
            <h3 class="text-white font-semibold mb-4">Connect</h3>
            <div class="flex space-x-4 mb-4">
                <a href="#" class="hover:text-white"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-youtube"></i></a>
            </div>
            <div>
                <label for="language" class="block mb-2">Language</label>
                <select id="language" class="bg-gray-800 border border-gray-700 text-sm rounded p-2 w-full">
                    <option>English</option>
                    <option>Français</option>
                    <option>Español</option>
                    <option>Deutsch</option>
                </select>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-800 py-4 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} Entrade. All rights reserved.
    </div>
</footer>
