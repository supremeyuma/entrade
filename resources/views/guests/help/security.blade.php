<x-layouts.guest :title="$title">
    <section class="py-12 md:py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl md:text-4xl font-bold text-gray-900 dark:text-white mb-8">{{ $title }}</h1>

            <div class="space-y-6">
                @foreach($faqs as $faq)
                    <div x-data="{ open: false }" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <button @click="open = !open" class="w-full text-left font-semibold text-gray-800 dark:text-white focus:outline-none">
                            {{ $faq['q'] }}
                        </button>
                        <div x-show="open" x-collapse class="mt-2 text-gray-600 dark:text-gray-300 text-sm">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.guest>
