<x-layouts.app>
    <div class="max-w-lg mx-auto px-4 py-6 sm:px-6 sm:py-8">
        <div class="rounded-2xl bg-white p-4 shadow-lg dark:bg-gray-800 sm:p-6">
            <h1 class="mb-2 text-xl font-bold text-gray-900 dark:text-white sm:text-2xl">
                Subscribe to {{ $trader->name }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                Trader ID: <span class="font-semibold">{{ $trader->trader_id }}</span>
            </p>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-4 p-4 text-green-800 bg-green-100 dark:bg-green-900/30 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 text-red-800 bg-red-100 dark:bg-red-900/30 dark:text-red-300 rounded-lg">
                    {{ session('error') }}
                    <a href="{{ route('user.deposit.create') }}" class="font-semibold text-green-700 hover:underline">
                        Please make a new deposit to continue.
                    </a>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-4 p-4 text-blue-800 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300 rounded-lg">
                    {{ session('info') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 p-4 text-red-800 bg-red-100 dark:bg-red-900/30 dark:text-red-300 rounded-lg">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Subscription Form --}}
            <form action="{{ route('user.subscribe', $trader->id) }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Amount to Allocate
                    </label>
                    <input
                        type="number"
                        name="amount"
                        id="amount"
                        min="1"
                        value="{{ old('amount') }}"
                        required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        placeholder="Enter amount"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition"
                >
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
