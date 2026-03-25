<x-layouts.admin>
    @php
        $isDark = session('theme', 'light') === 'dark';
        $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-white' : 'border-slate-200 bg-white text-slate-900';
        $heroOverlayClasses = $isDark
            ? 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.18),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,_#020617,_#0f172a_58%,_#111827)]'
            : 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
        $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
        $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
        $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
        $inputClasses = $isDark
            ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
            : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
    @endphp

    <div class="space-y-3 sm:space-y-6 max-w-4xl">
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Subscription Request</h1>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="max-w-2xl rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <dl class="divide-y divide-slate-200 dark:divide-slate-800">
                <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                    <dt class="font-medium {{ $mutedTextClasses }}">User</dt>
                    <dd class="{{ $headingClasses }}">{{ $subscription->user->name }}</dd>
                </div>
                <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                    <dt class="font-medium {{ $mutedTextClasses }}">Trader</dt>
                    <dd class="{{ $headingClasses }}">{{ $subscription->trader->name }}</dd>
                </div>
                <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                    <dt class="font-medium {{ $mutedTextClasses }}">Amount</dt>
                    <dd class="{{ $headingClasses }}">${{ number_format($subscription->allocated_amount, 2) }}</dd>
                </div>
                <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                    <dt class="font-medium {{ $mutedTextClasses }}">Status</dt>
                    <dd>
                        @php
                            $statusColors = [
                                'pending_approval' => 'bg-amber-100 text-amber-800 dark:bg-amber-500/10 dark:text-amber-300',
                                'active' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-300',
                                'approved' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-300',
                                'rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-500/10 dark:text-rose-300',
                            ];
                            $statusClass = $statusColors[$subscription->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300';
                        @endphp
                        <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
                        </span>
                    </dd>
                </div>
            </dl>

            @if($subscription->status === 'pending_approval')
                <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <form action="{{ route('admin.subscriptions.approve', $subscription->id) }}" method="POST" class="rounded-[18px] bg-emerald-50 p-4 shadow-sm dark:bg-emerald-500/10">
                        @csrf
                        <label for="approve_comment" class="mb-2 block text-sm font-medium {{ $mutedTextClasses }}">Approval Comment (optional)</label>
                        <textarea name="admin_comment" id="approve_comment" rows="3" class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}"></textarea>
                        <button type="submit" class="mt-3 w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">Approve</button>
                    </form>

                    <form action="{{ route('admin.subscriptions.reject', $subscription->id) }}" method="POST" class="rounded-[18px] bg-rose-50 p-4 shadow-sm dark:bg-rose-500/10">
                        @csrf
                        <label for="reject_comment" class="mb-2 block text-sm font-medium {{ $mutedTextClasses }}">Rejection Reason (optional)</label>
                        <textarea name="admin_comment" id="reject_comment" rows="3" class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}"></textarea>
                        <button type="submit" class="mt-3 w-full rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">Reject</button>
                    </form>
                </div>
            @elseif($subscription->status === 'active')
                <div class="mt-6 rounded-[18px] bg-amber-50 p-4 shadow-sm dark:bg-amber-500/10">
                    <form action="{{ route('admin.subscriptions.cancel', $subscription->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this subscription?');">
                        @csrf
                        <p class="mb-4 text-sm {{ $mutedTextClasses }}">Cancelling this subscription will refund the allocated amount to the user's main balance.</p>
                        <button type="submit" class="w-full rounded-2xl bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-amber-500 hover:shadow-lg active:scale-[0.99]">Cancel Subscription</button>
                    </form>
                </div>
            @endif
        </section>
    </div>
</x-layouts.admin>
