<x-layouts.guest>
<section class="bg-white dark:bg-gray-900 py-10 items-center">
    <div class="container">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold mb-2">About Bullsbybit</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Learn more about our mission, history, partners, and the people building Bullsbybit.
            </p>
        </div>

        <!-- Tabs -->
        <div x-data="{ tab: 'about' }" class="max-w-5xl mx-auto">
            <div class="flex justify-center mb-8">
                <div class="inline-flex rounded-full bg-gray-100 dark:bg-gray-800 p-1">
                <button @click="tab = 'about'" 
                    :class="tab === 'about' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300'"
                    class="px-4 py-2 text-sm font-medium rounded-full transition">
                    Who We Are
                </button>
                <!--<button @click="tab = 'brokers'" 
                    :class="tab === 'brokers' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300'"
                    class="px-4 py-2 text-sm font-medium rounded-full transition">
                    Our Brokers
                </button>
                <button @click="tab = 'awards'" 
                    :class="tab === 'awards' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300'"
                    class="px-4 py-2 text-sm font-medium rounded-full transition">
                    Awards
                </button>-->
                <button @click="tab = 'timeline'" 
                    :class="tab === 'timeline' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300'"
                    class="px-4 py-2 text-sm font-medium rounded-full transition">
                    Timeline
                </button>
                <button @click="tab = 'careers'" 
                    :class="tab === 'careers' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300'"
                    class="px-4 py-2 text-sm font-medium rounded-full transition">
                    Careers
                </button>
                </div>
        </div>


            <!-- Tab Sections -->
            <div x-show="tab === 'about'" x-cloak>
                @include('guests.about-sections.about')
            </div>
            <div x-show="tab === 'brokers'" x-cloak>
                @include('guests.about-sections.brokers')
            </div>
            <div x-show="tab === 'awards'" x-cloak>
                @include('guests.about-sections.awards')
            </div>
            <div x-show="tab === 'timeline'" x-cloak>
                @include('guests.about-sections.timeline')
            </div>
            <div x-show="tab === 'careers'" x-cloak>
                @include('guests.about-sections.careers')
            </div>
        </div>
    </div>
</section>
</x-layouts.guest>
