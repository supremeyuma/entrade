<x-layouts.admin>
    <div class="px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">All Users</h1>

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-x-auto">
            <table class="w-full table-auto text-left text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t dark:border-gray-700">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                            <td class="px-4 py-2">
                                <span class="text-xs px-2 py-1 rounded bg-gray-200 dark:bg-gray-700">
                                    {{ $user->status ?? 'active' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="text-blue-600 hover:underline mr-3">View</a>

                                <button
                                    @click="openModal({{ $user->id }})"
                                    class="text-yellow-600 hover:underline">
                                    Adjust Funds
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Fund Modal --}}
        <div x-data="{ showModal: false, targetUserId: null }">
            <div
                x-show="showModal"
                class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center"
            >
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-xl w-full max-w-xl relative z-50">
                    <h2 class="text-xl font-semibold mb-4">Adjust User Funds</h2>

                    <form method="POST" :action="`/admin/users/${targetUserId}/funds`">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Type</label>
                                <select name="type" required class="w-full rounded border-gray-300">
                                    <option value="credit">Credit</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Balance</label>
                                <select name="balance_type" required class="w-full rounded border-gray-300">
                                    <option value="main">Main Balance</option>
                                    <option value="trading">Trading Balance</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Category</label>
                                <select name="category" required class="w-full rounded border-gray-300">
                                    <option value="deposit">Deposit</option>
                                    <option value="withdrawal">Withdrawal</option>
                                    <option value="bonus">Bonus</option>
                                    <option value="trade">Trade</option>
                                    <option value="adjustment">Adjustment</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Amount (USD)</label>
                                <input type="number" step="0.01" min="0.01" name="amount"
                                       required class="w-full rounded border-gray-300">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium mb-1">User Note (visible to user)</label>
                            <textarea name="user_note" rows="2"
                                      class="w-full rounded border-gray-300"></textarea>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium mb-1">Admin Note (private)</label>
                            <textarea name="admin_note" rows="2"
                                      class="w-full rounded border-gray-300"></textarea>
                        </div>

                        <div class="mt-6 flex justify-end gap-4">
                            <button type="button" @click="showModal = false"
                                    class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function openModal(userId) {
                    const root = document.querySelector('[x-data]');
                    root.__x.$data.showModal = true;
                    root.__x.$data.targetUserId = userId;
                }
            </script>
        </div>
    </div>
</x-layouts.admin>
