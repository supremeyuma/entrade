<div class="bg-white dark:bg-gray-900 py-10">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold">Our Broker Partners</h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Entrade partners with leading global brokers to ensure secure, seamless, and efficient trade execution.
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
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