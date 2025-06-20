<x-layouts.guest :title="$title">
    <section class="py-12 md:py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4"
             x-data="{
                 selected: null,
                 search: '',
                 normalize(text) {
                     return text.toLowerCase();
                 },
                 match(text, term) {
                     if (!term) return text;
                     const regex = new RegExp('(' + term.replace(/[-[\]/{}()*+?.\\^$|]/g, '\\$&') + ')', 'gi');
                     return text.replace(regex, '<mark class=\'bg-yellow-200 dark:bg-yellow-600 text-black dark:text-white\'>$1</mark>');
                 }
             }"
        >
            <h1 class="text-2xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">{{ $title }}</h1>

            <!-- Search Input -->
            <div class="mb-6 max-w-2xl mx-auto relative">
                <input
                    type="text"
                    x-model="search"
                    placeholder="Search questions..."
                    class="w-full border border-gray-300 dark:border-gray-700 rounded-full px-4 py-2 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white"
                />
                <svg class="w-5 h-5 absolute right-4 top-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>

            <!-- Accordion -->
            <div class="space-y-4">
                @foreach($faqs as $index => $faq)
                    <div
                        x-show="search === '' || normalize(`{{ $faq['q'] }} {{ $faq['a'] }}`).includes(normalize(search))"
                        class="border border-gray-200 dark:border-gray-700 rounded-md shadow-sm p-4"
                        x-init="$watch('search', val => {
                            const current = normalize(`{{ $faq['q'] }} {{ $faq['a'] }}`);
                            if (!current.includes(normalize(val))) selected = null;
                        })"
                    >
                        <button
                            @click="selected === {{ $index }} ? selected = null : selected = {{ $index }}"
                            class="flex justify-between items-center w-full text-left text-gray-900 dark:text-white font-medium text-base md:text-lg focus:outline-none"
                        >
                            <span x-html="match(`{!! e($faq['q']) !!}`, search)"></span>
                            <svg
                                :class="{ 'rotate-180': selected === {{ $index }} }"
                                class="w-5 h-5 transform transition-transform duration-200 text-gray-500 dark:text-gray-300"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div
                            x-show="selected === {{ $index }}"
                            x-collapse
                            class="mt-3 text-sm md:text-base text-gray-700 dark:text-gray-300 leading-relaxed"
                        >
                            <span x-html="match(`{!! e($faq['a']) !!}`, search)"></span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results -->
            <div x-show="search !== '' && document.querySelectorAll('[x-show]').length <= 0"
                 class="text-center text-gray-600 dark:text-gray-400 mt-10">
                No results found.
            </div>
        </div>
    </section>
</x-layouts.guest>
