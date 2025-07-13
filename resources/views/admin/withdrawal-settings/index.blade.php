<x-layouts.admin>
    <div class="max-w-4xl mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6">Withdrawal Fee Settings</h2>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.withdrawal-settings.store') }}" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded shadow">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <input name="cryptocurrency" placeholder="e.g. BTC" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                <input name="min_amount" placeholder="Min" type="number" step="any" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                <input name="max_amount" placeholder="Max" type="number" step="any" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                <input name="fixed_fee" placeholder="Fixed Fee" type="number" step="any" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                <input name="percent_fee" placeholder="Percent Fee" type="number" step="any" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
            </div>
            <div class="flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>

        <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
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
</x-layouts.admin>
