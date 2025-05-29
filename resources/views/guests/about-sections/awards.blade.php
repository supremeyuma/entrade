<div class="bg-white dark:bg-gray-900 py-10">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold">Awards & Recognition</h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Entrade is honored to have received numerous industry awards for innovation, transparency, and service excellence.
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
        @foreach ([
            'global-brands-award.png' => 'Global Brands Magazine',
            'forex-brokers-award.png' => 'ForexBrokers.com',
            'world-finance-award.png' => 'World Finance Awards',
            'finance-magnates-award.png' => 'Finance Magnates',
            'investing-award.png' => 'Investing.com',
            'europa-award.png' => 'Europa Awards',
            'fxdaily-award.png' => 'FXDaily Report',
            'global-finance-award.png' => 'Global Finance',
        ] as $logo => $issuer)
            <div class="flex flex-col items-center bg-gray-50 dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                <img src="{{ asset('images/awards/' . $logo) }}" alt="{{ $issuer }} Award" class="h-12 object-contain mb-2" />
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200 text-center">{{ $issuer }}</span>
            </div>
        @endforeach
    </div>
</div>
