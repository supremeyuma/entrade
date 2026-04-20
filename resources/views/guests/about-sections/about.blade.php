<section class="relative bg-white dark:bg-gray-900 py-16">
    <div class="max-w-6xl mx-auto px-6 py-3 lg:px-8 grid lg:grid-cols-2 gap-12 items-center bodyBG">
        <!-- Image / Illustration -->
        <div class="flex justify-center">
            <img src="https://www.svgrepo.com/show/339918/chart-candlestick.svg" 
                 alt="Who We Are" 
                 class="max-w-sm lg:max-w-md">
        </div>

        <!-- Content -->
        <div>
            <h2 class="text-gray-700 dark:text-gray-900 text-4xl font-bold mb-6">
                Who <span class="text-primary">We Are</span>
            </h2>
            <p class="text-lg text-gray-700 dark:text-gray-900 leading-relaxed mb-6">
                Bullsbybit is a next-generation copy trading platform that empowers individuals 
                to automatically mirror the trades of top-performing investors. 
                Our mission is to bridge the gap between novice investors and 
                seasoned professionals with a transparent, secure, and easy-to-use ecosystem.
            </p>

            <div class="grid grid-cols-3 gap-6 text-center">
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-md transition">
                    <div class="text-4xl font-bold text-primary mb-2">+50k</div>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">Registered Users</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-md transition">
                    <div class="text-4xl font-bold text-primary mb-2">$20M+</div>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">Copied Trading Volume</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-md transition">
                    <div class="text-4xl font-bold text-primary mb-2">+100</div>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">Verified Traders</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Brokers-->

<div class="flex flex-col justify-center items-center bg-white dark:bg-gray-900 py-10 px-2">
    <div class="text-center mb-8 w-full">
        <h2 class="text-3xl font-bold">Our Broker Partners</h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Bullsbybit partners with leading global brokers to ensure secure, seamless, and efficient trade execution.
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 max-w-6xl ">
        @foreach ([
            'activtrades.png' => 'ActivTrades',
            'avatrade.png' => 'AvaTrade',
            'blackbull.png' => 'Black Bull',
            'icmarkets.png' => 'IC Markets',
            'fxview.png' => 'FXView',
            'dbinvest.png' => 'DbInvest',
            'tickmill.png' => 'Tick Mill',
            'yamarkets.png' => 'YaMarkets',
        ] as $logo => $name)
            <div class="flex flex-col items-center bg-gray-50 dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                <img src="{{ asset('images/brokers/' . $logo) }}" alt="{{ $name }} Logo" class="h-12 object-contain mb-2" />
                <!--<span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $name }}</span>-->
            </div>
        @endforeach
    </div>
</div>

<!--Awards-->

<div class="flex flex-col justify-center items-center bg-white dark:bg-gray-900 py-10 px-2 mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold">Awards & Recognition</h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Bullsbybit is honored to have received numerous industry awards for innovation, transparency, and service excellence.
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
        @foreach ([
            'UF AWARDS MEA' => 'DUBAI, 2024',
            'UF AWARDS GLOBAL' => 'CYPRUS, 2023',
            'UF AWARDS' => 'BANGKOK 2023',
            'FAME AWARD' => 'SA, 2023',
            'UF AWARDS' => 'DUBAI, 2023',
            'UF AWARDS' => 'CYPRUS, 2022',
            'FOREX EXPO' => 'DUBAI, 2022',
        ] as $award => $location)
           

            <div class="relative inline-block">
                <img src="/images/awardLeaf.svg" alt="Award Leaf" class="mx-auto block">
                
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                    <span class="text-base f-14 px-10 font-semibold text-gray-700 dark:text-gray-200">
                        {{ $award }} {{ $location }}
                    </span>
                    <span class="text-base font-semibold text-gray-700 dark:text-gray-200">
                        
                    </span>
        </div>
            </div>


        @endforeach
    </div>
</div>


<section class="blockElement space ourLocation bg-white dark:bg-gray-900">
    <div class="container"><div class="row justify-content-center">
        <div class="col-12 col-md-6 text-center mb-4">
            <h2 class="mb-md-4">Our <span class="secondary">Offices</span>
            </h2><p class="mb-0"><span class="bold">ZuluTrade’s</span> head office is based in <span class="bold">Greece</span>. </p>
            <p class="mb-0">The corporate office is in <span class="bold">Cyprus</span> and we have another office in <span class="bold">JAPAN</span>.</p>
            <p>Finvasia Group has it’s offices in <span class="bold">Dubai</span>, 
            <span class="bold">Greece</span>, 
            <span class="bold">JAPAN</span>, 
            <span class="bold">Cyprus</span>, 
            <span class="bold">London</span>, 
            <span class="bold">South Africa</span>, 
            <span class="bold">Australia</span>, 
            <span class="bold">Mauritius</span> and 
            <span class="bold">India</span>. </p>
        </div>
        <div class="world-map col-12 col-md-8 text-center mapLocation mb-4 ">
            <img src="/images/mapLocation.svg" class="lightTheme v-lazy-image v-lazy-image-loaded" alt="Our Offices" title="Word Map">
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="darkTheme d-none v-lazy-image" alt="Our Offices" title="Word Map">
        </div>
        <div class="flex promo-container flex flex-row justify-center items-center p-6 md:p-8 w-full max-w-4xl">
            <div class="gif-container mr-0 md:mr-6 mb-4 md:mb-0">
                <img src="/assets/images/loudLayer.gif" alt="Interested in our Services?" title="Interested">
            </div>

            <div class="flex flex-col md:flex-row text-gray-600 dark:text-gray-300 items-center">
                    <h2 class="flex flex-col font-bold mb-0 mx-3 text-2xl md:text-3xl text-gray-800 dark:text-gray-900">Interested in our Services?</h2>
                    <a href="/register/" class="btn-account px-4 py-3 mt-4 md:mt-0 md:ms-5 flex items-center justify-center">Open your account</a>
            </div>
        </div>
    </div>
</section>
