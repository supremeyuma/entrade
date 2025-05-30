@extends('layouts.guest')

@section('content')
<section class="bg-white dark:bg-gray-900 py-10">
    <div class="container">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold mb-2">About Entrade</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Learn more about our mission, history, partners, and the people building Entrade.
            </p>
        </div>

        <!-- Tabs -->
        <div x-data="{ tab: 'about' }" class="max-w-5xl mx-auto">
            <div class="flex flex-wrap justify-center gap-2 mb-8 border-b border-gray-200 dark:border-gray-700">
                <button @click="tab = 'about'" :class="{ 'border-primary text-primary': tab === 'about' }"
                    class="px-4 py-2 text-sm font-medium border-b-2 border-transparent hover:text-primary">
                    Who We Are
                </button>
                <button @click="tab = 'brokers'" :class="{ 'border-primary text-primary': tab === 'brokers' }"
                    class="px-4 py-2 text-sm font-medium border-b-2 border-transparent hover:text-primary">
                    Our Brokers
                </button>
                <button @click="tab = 'awards'" :class="{ 'border-primary text-primary': tab === 'awards' }"
                    class="px-4 py-2 text-sm font-medium border-b-2 border-transparent hover:text-primary">
                    Awards
                </button>
                <button @click="tab = 'timeline'" :class="{ 'border-primary text-primary': tab === 'timeline' }"
                    class="px-4 py-2 text-sm font-medium border-b-2 border-transparent hover:text-primary">
                    Timeline
                </button>
                <button @click="tab = 'careers'" :class="{ 'border-primary text-primary': tab === 'careers' }"
                    class="px-4 py-2 text-sm font-medium border-b-2 border-transparent hover:text-primary">
                    Careers
                </button>
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
@endsection
