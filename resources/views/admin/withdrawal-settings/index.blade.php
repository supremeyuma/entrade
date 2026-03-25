<x-layouts.admin>
    <div class="max-w-4xl mx-auto px-4 py-6 sm:py-10">
        <h2 class="mb-4 text-xl font-bold sm:mb-6 sm:text-2xl">Withdrawal Fee Settings</h2>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.withdrawal-settings.store') }}" class="space-y-4 rounded bg-white p-4 shadow dark:bg-gray-800 sm:p-6">
            @csrf
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <input name="cryptocurrency" placeholder="e.g. BTC" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                <input name="min_amount" placeholder="Min" type="number" step="any" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                <input name="max_amount" placeholder="Max" type="number" step="any" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                <input name="fixed_fee" placeholder="Fixed Fee" type="number" step="any" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                <input name="percent_fee" placeholder="Percent Fee" type="number" step="any" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
            </div>
            <div class="flex justify-end">
                <button class="w-full rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700 sm:w-auto">Save</button>
            </div>
        </form>

        <div class="mt-8 rounded bg-white p-4 shadow dark:bg-gray-800 sm:p-6">
            <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr>
                        <th>Crypto</th><th>Min</th><th>Max</th><th>Fixed</th><th>Percent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($settings as $setting)
                        <tr class="border-b">
                            <td>{{ $setting->cryptocurrency }}</td>
                            <td>{{ $setting->min_amount }}</td>
                            <td>{{ $setting->max_amount }}</td>
                            <td>{{ $setting->fixed_fee }}</td>
                            <td>{{ $setting->percent_fee }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
