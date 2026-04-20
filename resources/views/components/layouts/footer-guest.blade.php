@php
    $isDark = request()->cookie('theme') === 'dark'; // optional: depends on your theme logic
@endphp

<footer 
    class="border-t px-6 pt-10 pb-6 transition-colors duration-300"
    :class="{
        'bg-gray-900 text-gray-300 border-gray-800': $store.theme.isDark,
        'bg-gray-50 text-gray-700 border-gray-200': !$store.theme.isDark
    }"
    x-data="{ openSections: {} }"
>
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-6 gap-8">
        <!-- Products -->
        <div>
            <h3 class="font-semibold text-base mb-3 cursor-pointer md:cursor-default" @click="openSections['products'] = !openSections['products']">
                Products
            </h3>
            <ul class="space-y-2" :class="{ 'hidden md:block': !openSections['products'] }">
                <li><a href="{{ route('copy-trading') }}" class="hover:underline">Copy Trading</a></li>
                <li><a href="{{ route('traders.index') }}" class="hover:underline">Traders</a></li>
                <li><a href="{{ route('referral-program') }}" class="hover:underline">Referral Program</a></li>
            </ul>
        </div>

        <!-- Company -->
        <div>
            <h3 class="font-semibold text-base mb-3 cursor-pointer md:cursor-default" @click="openSections['company'] = !openSections['company']">
                Company
            </h3>
            <ul class="space-y-2" :class="{ 'hidden md:block': !openSections['company'] }">
                <li><a href="{{ route('about') }}" class="hover:underline">About Bullsbybit</a></li>
                <li><a href="{{ route('careers') }}" class="hover:underline">Careers</a></li>
                <!--<li><a href="{{ route('blog') }}" class="hover:underline">Blog</a></li>-->
                <!--<li><a href="{{ route('contact') }}" class="hover:underline">Contact</a></li>-->
            </ul>
        </div>

        <!-- Learn -->
        <div>
            <h3 class="font-semibold text-base mb-3 cursor-pointer md:cursor-default" @click="openSections['learn'] = !openSections['learn']">
                Learn
            </h3>
            <ul class="space-y-2" :class="{ 'hidden md:block': !openSections['learn'] }">
                <li><a href="{{ route('learn.faq') }}" class="hover:underline">FAQs</a></li>
                <li><a href="{{ route('user-guide') }}" class="hover:underline">User Guides</a></li>
                <!--<li><a href="{{ route('learn.simulator') }}" class="hover:underline">Trade Simulator</a></li>-->
                <!--<li><a href="{{ route('learn.webinars') }}" class="hover:underline">Webinars</a></li>-->
            </ul>
        </div>

        <!-- Legal -->
        <div>
            <h3 class="font-semibold text-base mb-3 cursor-pointer md:cursor-default" @click="openSections['legal'] = !openSections['legal']">
                Legal
            </h3>
            <ul class="space-y-2" :class="{ 'hidden md:block': !openSections['legal'] }">
                <li><a href="{{ route('terms') }}" class="hover:underline">Terms of Service</a></li>
                <li><a href="{{ route('privacy') }}" class="hover:underline">Privacy Policy</a></li>
                <li><a href="{{ route('risk') }}" class="hover:underline">Risk Disclosure</a></li>
                <li><a href="{{ route('cookies') }}" class="hover:underline">Cookies Policy</a></li>
            </ul>
        </div>

        <!-- Connect -->
        <div>
            <h3 class="font-semibold text-base mb-3">Connect</h3>
            <div class="flex space-x-4 mb-4">
                <a href="#" class="hover:text-primary"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-primary"><i class="fab fa-x-twitter"></i></a>
                <a href="#" class="hover:text-primary"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="hover:text-primary"><i class="fab fa-youtube"></i></a>
            </div>
            <div>
                <label for="language" class="block mb-1 text-sm">Language</label>
                <select id="language" class="bg-transparent border rounded px-2 py-1 w-full text-sm">
                    <option value="en" selected>🇺🇸 English</option>
                    <option value="fr">🇫🇷 Français</option>
                    <option value="es">🇪🇸 Español</option>
                    <option value="de">🇩🇪 Deutsch</option>
                </select>
            </div>
        </div>

        <!-- Contact -->
        <div>
            <h3 class="font-semibold text-base mb-3">Contact</h3>
            <p>✉️ support@bullsbybit.com</p>
        </div>
    </div>

    <div class="mt-10 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} Bullsbybit. All rights reserved.
    </div>
</footer>
