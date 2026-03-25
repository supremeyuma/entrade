<x-layouts.admin>
    @php
        $isDark = session('theme', 'light') === 'dark';
        $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-white' : 'border-slate-200 bg-white text-slate-900';
        $heroOverlayClasses = $isDark
            ? 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.18),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,_#020617,_#0f172a_58%,_#111827)]'
            : 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
        $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
        $subtleSurfaceClasses = $isDark ? 'bg-slate-800 text-slate-300' : 'bg-slate-50 text-slate-600';
        $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
        $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
        $inputClasses = $isDark
            ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
            : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
    @endphp

    <div class="space-y-3 sm:space-y-6" x-data="{ 
        showModal: false, 
        targetUserId: null,
        openModal(userId) {
            this.targetUserId = userId;
            this.showModal = true;
        }
    }">
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">All Users</h1>
                    <p class="mt-1 text-[11px] sm:mt-2 sm:text-sm {{ $mutedTextClasses }}">Review user roles, open profiles, and adjust balances from one table.</p>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="w-full table-auto text-left text-sm">
                <thead class="{{ $subtleSurfaceClasses }} uppercase">
                    <tr>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Name</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Email</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Role</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Status</th>
                        <th class="px-3 py-2 text-right sm:px-4 sm:py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @foreach ($users as $user)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $user->name }}</td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $user->email }}</td>
                            <td class="px-3 py-2 capitalize sm:px-4 sm:py-3">{{ $user->roles->pluck('name')->implode(', ') ?: 'No role' }}</td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs dark:bg-slate-800">
                                    {{ $user->status ?? 'active' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-right sm:px-4 sm:py-3">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="mr-3 text-sky-600 hover:underline">View</a>

                                <button
                                    @click="openModal({{ $user->id }})"
                                    class="text-amber-600 hover:underline">
                                    Adjust Funds
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <div
            x-show="showModal"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/50 px-4 backdrop-blur-sm"
        >
            <div
                x-show="showModal"
                x-cloak
                x-transition.scale
                class="relative z-50 w-full max-w-xl rounded-[24px] border p-4 shadow-2xl sm:p-6 {{ $surfaceClasses }}"
            >
                <h2 class="mb-4 text-lg font-semibold {{ $headingClasses }}">Adjust User Funds</h2>

                <form method="POST" :action="`/admin/users/${targetUserId}/funds`">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium {{ $mutedTextClasses }}">Type</label>
                            <select name="type" required class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                                <option value="credit">Credit</option>
                                <option value="debit">Debit</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium {{ $mutedTextClasses }}">Balance</label>
                            <select name="balance_type" required class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                                <option value="main">Main Balance</option>
                                <option value="trading">Trading Balance</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium {{ $mutedTextClasses }}">Category</label>
                            <select name="category" required class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                                <option value="deposit">Deposit</option>
                                <option value="withdrawal">Withdrawal</option>
                                <option value="bonus">Bonus</option>
                                <option value="trade">Trade</option>
                                <option value="adjustment">Adjustment</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium {{ $mutedTextClasses }}">Amount (USD)</label>
                            <input type="number" step="0.01" min="0.01" name="amount"
                                   required class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="mb-1 block text-sm font-medium {{ $mutedTextClasses }}">User Note (visible to user)</label>
                        <textarea name="user_note" rows="2"
                                  class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}"></textarea>
                    </div>

                    <div class="mt-4">
                        <label class="mb-1 block text-sm font-medium {{ $mutedTextClasses }}">Admin Note (private)</label>
                        <textarea name="admin_note" rows="2"
                                  class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}"></textarea>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showModal = false"
                                class="rounded-2xl border px-4 py-2 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-md {{ $surfaceClasses }}">
                            Cancel
                        </button>
                        <button type="submit"
                                class="rounded-2xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
