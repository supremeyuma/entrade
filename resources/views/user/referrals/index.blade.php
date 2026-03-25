<x-layouts.app>
<div class="max-w-4xl mx-auto px-4 py-6 space-y-4 sm:space-y-6">

    <h2 class="mb-4 text-xl font-bold sm:text-2xl">My Referrals</h2>

    {{-- Referral Link + Copy --}}
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4 space-y-2">
        <label class="block font-semibold text-sm">Your Referral Link</label>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:space-x-2">
            <input type="text"
                   readonly
                   value="{{ auth()->user()->referral_link }}"
                   class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white text-sm">
            <button
                @click="navigator.clipboard.writeText('{{ auth()->user()->referral_link }}')"
                class="w-full rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700 sm:w-auto">
                Copy
            </button>
        </div>
    </div>

    {{-- Bonus Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow text-sm">
            <p class="text-gray-600 dark:text-gray-300">Total Referrals</p>
            <p class="text-lg font-bold">{{ auth()->user()->referralCount() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow text-sm">
            <p class="text-gray-600 dark:text-gray-300">Total Bonus Earned</p>
            <p class="text-lg font-bold">${{ number_format(auth()->user()->referralBonusTotal(), 2) }}</p>
        </div>
    </div>

    {{-- Referrals Table --}}
    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow overflow-x-auto">
        <h3 class="text-lg font-semibold mb-3">Referral History</h3>

        @if($referrals->count())
            <table class="w-full text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr class="text-left">
                        <th class="p-2">#</th>
                        <th class="p-2">Name</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Referred On</th>
                        <th class="p-2">Bonus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($referrals as $referral)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="p-2">{{ $loop->iteration }}</td>
                            <td class="p-2">{{ $referral->referred->name ?? '-' }}</td>
                            <td class="p-2">{{ $referral->referred->email ?? '-' }}</td>
                            <td class="p-2">{{ $referral->referred_at?->format('d M Y') ?? '-' }}</td>
                            <td class="p-2">
                                ${{ number_format($referral->bonus_amount ?? 0, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400">You have not referred anyone yet.</p>
        @endif
    </div>

</div>
</x-layouts.app>
