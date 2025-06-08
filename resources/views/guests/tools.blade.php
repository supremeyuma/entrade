@php
    $section = request()->query('section', 'economic-calendar');
@endphp

<x-layouts.guest>
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-16">
        @switch($section)
            @case('economic-calendar')
                <x-tools.economic-calendar />
                @break
            @case('market-news')
                <x-tools.market-news />
                @break
            @case('trading-signals')
                <x-tools.trading-signals />
                @break
            @case('pip-calculator')
                <x-tools.pip-calculator />
                @break
            @case('copy-guide')
                <x-tools.copy-guide />
                @break
            @case('trading-hours')
                <x-tools.trading-hours />
                @break
            @case('risk-tips')
                <x-tools.risk-tips />
                @break
            @case('currency-converter')
                <x-tools.currency-converter />
                @break
            @case('margin-calculator')
                <x-tools.margin-calculator />
                @break
            @case('live-charts')
                <x-tools.live-charts />
                @break
            @default
                <x-tools.economic-calendar />
        @endswitch
    </div>
</x-layouts.guest>
