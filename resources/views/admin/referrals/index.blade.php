<x-layouts.admin>
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-100 sm:mb-6 sm:text-2xl">All Referrals</h2>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Referrer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Referred User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Referred At</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($referrals as $referral)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $referral->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ $referral->referrer->name }}<br>
                                <span class="text-xs text-gray-500">ID: {{ $referral->referrer_id }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ $referral->referred->name }}<br>
                                <span class="text-xs text-gray-500">ID: {{ $referral->referred_id }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                {{ $referral->referred_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium
                                    {{ $referral->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100' }}">
                                    {{ ucfirst($referral->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($referral->status == 'pending')
                                    <form action="{{ route('admin.referrals.approve', $referral->id) }}" method="POST">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="px-3 py-1 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded shadow"
                                        >
                                            Approve & Pay
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500 dark:text-gray-400">No referrals found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $referrals->links() }}
        </div>
    </div>
</x-layouts.admin>
