@props(['faqs'])

<div
    x-data="{
        search: '',
        hasInput: false,
        get visibleResults() {
            return this.hasInput && this.$refs.resultsContainer.querySelectorAll('[x-show=\'true\']').length;
        },
        normalize(text) {
            return text.toLowerCase();
        },
        match(text, term) {
            if (!term) return text;
            const safeTerm = term.replace(/[-[\]/{}()*+?.\\^$|]/g, '\\$&');
            const regex = new RegExp('(' + safeTerm + ')', 'gi');
            return text.replace(regex, '<mark class=\'bg-yellow-200 dark:bg-yellow-600 text-black dark:text-white\'>$1</mark>');
        }
    }"
>
    <!-- Search Input -->
    <div class="max-w-2xl mx-auto mb-8">
        <div class="relative">
            <input
                type="text"
                x-model="search"
                @input="hasInput = search.length > 0"
                class="w-full rounded-full border border-gray-300 dark:border-gray-700 px-5 md:px-6 py-2.5 md:py-3 pl-11 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white"
                placeholder="   Search..."
            >
            <div class="absolute left-4 top-2.5 md:top-3 text-gray-400 dark:text-gray-500">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Accordion FAQ List -->
    <div class="space-y-4" x-ref="resultsContainer">
        <!-- Show message when no input -->
        <!--<div x-show="!hasInput" class="text-center py-8 text-gray-500 dark:text-gray-400">
            Type in the search bar above to find FAQs
        </div>-->

        @foreach($faqs as $index => $faq)
            <div
                x-show="hasInput && normalize(`{{ $faq['question'] }} {{ $faq['answer'] }}`).includes(normalize(search))"
                class="border border-gray-200 dark:border-gray-700 rounded-md shadow-sm p-4"
                x-data="{ open: false }"
            >
                <button
                    @click="open = !open"
                    class="flex justify-between items-center w-full text-left text-gray-900 dark:text-white font-medium text-base md:text-lg focus:outline-none"
                >
                    <span x-html="match(`{!! e($faq['question']) !!}`, search)"></span>
                    <svg
                        :class="{ 'rotate-180': open }"
                        class="w-5 h-5 transform transition-transform duration-200 text-gray-500 dark:text-gray-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" x-collapse class="mt-3 text-sm md:text-base text-gray-700 dark:text-gray-300 leading-relaxed">
                    <span x-html="match(`{!! e($faq['answer']) !!}`, search)"></span>
                </div>
            </div>
        @endforeach

        <!-- Show message when no results found -->
        <div 
            x-show="hasInput && !visibleResults"
            class="text-center py-8 text-gray-500 dark:text-gray-400"
        >
            No results found for "<span x-text="search"></span>"
        </div>
    </div>
</div>