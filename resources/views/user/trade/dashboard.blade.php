@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $subtleSurfaceClasses = $isDark ? 'bg-slate-800/80' : 'bg-slate-50';
    $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
    $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
    $inputClasses = $isDark
        ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<x-layouts.app>
    <div class="mx-auto max-w-5xl px-4 py-6 sm:py-8">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <div class="pointer-events-none absolute -right-10 top-6 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl animate-pulse"></div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $mutedTextClasses }}">Trading</p>
                    <div class="mt-3 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold tracking-tight sm:text-3xl">My Copied Traders</h2>
                            <p class="mt-2 text-sm {{ $bodyTextClasses }}">Track subscribed traders and move funds between balances.</p>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl border px-4 py-3 backdrop-blur {{ $surfaceClasses }}">
                                <p class="text-xs uppercase tracking-[0.18em] {{ $mutedTextClasses }}">Main Balance</p>
                                <p class="mt-1 text-lg font-semibold {{ $headingClasses }}">${{ number_format($user->balance->main_balance, 2) }}</p>
                            </div>
                            <div class="rounded-2xl border px-4 py-3 backdrop-blur {{ $surfaceClasses }}">
                                <p class="text-xs uppercase tracking-[0.18em] {{ $mutedTextClasses }}">Trade Balance</p>
                                <p class="mt-1 text-lg font-semibold {{ $headingClasses }}">${{ number_format($user->balance->trade_balance, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if($subscriptions->isEmpty())
                <div data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-5 text-sm shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                    <p class="{{ $bodyTextClasses }}">You are not copying any traders yet.</p>
                    <a href="{{ route('user.trade.search') }}" class="mt-3 inline-flex rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">Search for a trader</a>
                </div>
            @else
                @if(session('success'))
                    <div data-aos="fade-up" data-aos-delay="120" class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                        {{ session('success') }}
                    </div>
                @endif

                <section data-aos="fade-up" data-aos-delay="160" class="space-y-4">
                    <h3 class="text-lg font-semibold {{ $headingClasses }} sm:text-xl">Your Trader Subscriptions</h3>

                    @foreach ($user->traderSubscriptions as $subscription)
                        @if($subscription->status == 'active')
                            <div class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-5 {{ $surfaceClasses }}">
                                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold text-emerald-600 dark:text-emerald-400">{{ $subscription->trader->name }}</h4>
                                        <p class="text-sm {{ $bodyTextClasses }}">Allocated Amount: ${{ number_format($subscription->allocated_amount, 2) }}</p>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('user.trader.outcome.show', $subscription->trader->id) }}" class="rounded-2xl border px-3 py-2 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-md {{ $surfaceClasses }} {{ $headingClasses }}">View Outcomes</a>
                                        <form action="{{ route('user.unsubscribe', $subscription->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rounded-2xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">Unsubscribe</button>
                                        </form>
                                    </div>
                                </div>

                                <form action="{{ route('user.updateAllocation', $subscription->id) }}" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    @csrf
                                    <div>
                                        <label for="amount-{{ $subscription->id }}" class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Change Allocation</label>
                                        <input type="number" name="amount" id="amount-{{ $subscription->id }}" min="1"
                                            value="{{ $subscription->allocated_amount }}"
                                            class="block w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="submit"
                                            class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:px-5 sm:py-3">
                                            Update Allocation
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @elseif($subscription->status == 'pending_approval')
                            <div class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-5 {{ $surfaceClasses }}">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold text-emerald-600 dark:text-emerald-400">{{ $subscription->trader->name }}</h4>
                                        <p class="text-sm {{ $bodyTextClasses }}">Allocated Amount: ${{ number_format($subscription->allocated_amount, 2) }}</p>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="rounded-2xl bg-amber-50 px-3 py-2 text-sm font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-300">Awaiting Approval</span>
                                        <form action="{{ route('user.unsubscribe', $subscription->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rounded-2xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-5 {{ $surfaceClasses }}">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold {{ $headingClasses }}">{{ $subscription->trader->name }} is not active</h4>
                                    </div>
                                    <form action="{{ route('user.trade.showSubscribeForm', $subscription->id) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="rounded-2xl bg-emerald-600 px-3 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">Subscribe</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </section>

                <section data-aos="fade-up" data-aos-delay="240" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                    <h3 class="mb-4 text-lg font-semibold {{ $headingClasses }} sm:text-xl">Transfer Funds Between Balances</h3>
                    <form action="{{ route('user.transferFunds') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="amount" class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Amount</label>
                                <input type="number" name="amount" id="amount" min="1" required
                                    class="block w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}">
                            </div>
                            <div>
                                <label for="transfer_type" class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Transfer Type</label>
                                <select name="transfer_type" id="transfer_type" required
                                    class="block w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}">
                                    <option value="main_to_trade">Main Balance to Trade Balance</option>
                                    <option value="trade_to_main">Trade Balance to Main Balance</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                                Transfer Funds
                            </button>
                        </div>
                    </form>
                </section>
            @endif
        </div>
    </div>
</x-layouts.app>
