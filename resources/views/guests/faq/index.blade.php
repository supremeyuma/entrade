<x-layouts.guest title="Help Center">
<section class="bg-gray-50 dark:bg-gray-900 py-12 md:py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-2xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 md:mb-4">Need Help?</h1>
            <p class="text-sm md:text-lg text-gray-600 dark:text-gray-300 mb-4 md:mb-6">
                <span class="block md:hidden">Find answers fast.</span>
                <span class="hidden md:block">Find answers to frequently asked questions or get in touch with us.</span>
            </p>
            
            <x-faq.search-panel :faqs="$faqs" />
        </div>
    </section>

    <!--<section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-10">How can we help you?</h1>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <a href="{{ route('faq.category', $category->slug) }}"
                       class="group border border-gray-200 dark:border-gray-700 rounded-xl p-4 md:p-6 hover:shadow-lg transition">
                        <div class="text-2xl md:text-4xl mb-2 md:mb-4">{{ $category->icon }}</div>
                        <h3 class="text-base md:text-xl font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600">
                            {{ $category->title }}
                        </h3>
                        <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mt-1 md:mt-2">
                            {{ $category->faqs_count }} FAQs
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>-->

    
    <section class="py-12 md:py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $category)
                <a href="{{ route('faq.category', ['slug' => $category['slug']]) }}"
                    class="group border border-gray-200 dark:border-gray-700 rounded-xl p-4 md:p-6 hover:shadow-lg transition">

                        <div class="text-2xl md:text-4xl mb-2 md:mb-4">{{ $category['icon'] }}</div>
                        <h3 class="text-base md:text-xl font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600">
                            {{ $category['title'] }}
                        </h3>
                        <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mt-1 md:mt-2">
                            <span class="block md:hidden">{{ $category->description['short'] }}</span>
                            <span class="hidden md:block">{{ $category->description['long'] }}</span>
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white dark:bg-gray-800 py-10 md:py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-lg md:text-2xl font-bold text-gray-900 dark:text-white mb-3 md:mb-4">Need more help?</h2>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mb-4 md:mb-6">We're here 24/7.</p>
            <a href="{{ route('faq.index') }}"
               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 md:px-6 md:py-3 rounded-full transition text-sm md:text-base">
                Contact Support
            </a>
        </div>
    </section>

</x-layouts.guest>
