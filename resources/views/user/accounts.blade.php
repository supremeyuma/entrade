{{-- resources/views/user/accounts.blade.php --}}
@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark
        ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20'
        : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
    $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
    $tabIdleClasses = $isDark
        ? 'border-slate-800 bg-slate-900/80 text-slate-300 hover:border-slate-700 hover:bg-slate-800/90 hover:text-slate-100'
        : 'border-slate-200 bg-white/80 text-slate-600 hover:border-slate-300 hover:bg-white hover:text-slate-900';
    $tabActiveClasses = $isDark
        ? 'border-emerald-400/40 bg-emerald-500/10 text-emerald-300 shadow-lg shadow-emerald-950/30'
        : 'border-emerald-200 bg-emerald-50 text-emerald-700 shadow-lg shadow-emerald-100/60';
    $dangerActiveClasses = $isDark
        ? 'border-rose-400/40 bg-rose-500/10 text-rose-300 shadow-lg shadow-rose-950/30'
        : 'border-rose-200 bg-rose-50 text-rose-700 shadow-lg shadow-rose-100/60';
@endphp

<x-layouts.app>
    <div class="mx-auto max-w-6xl px-4 py-6 sm:py-8" x-data="{ tab: 'profile' }">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <div class="pointer-events-none absolute -right-10 top-6 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl animate-pulse"></div>
                    <div class="pointer-events-none absolute -left-6 bottom-0 h-20 w-20 rounded-full bg-emerald-400/10 blur-2xl animate-pulse"></div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $mutedTextClasses }}">Account</p>
                    <div class="mt-3 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold tracking-tight sm:text-3xl {{ $headingClasses }}">Account Settings</h1>
                            <p class="mt-2 text-sm {{ $bodyTextClasses }}">Manage profile details, security, alerts, and verification from one place.</p>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="rounded-2xl border px-4 py-3 backdrop-blur {{ $surfaceClasses }}">
                                <p class="text-xs uppercase tracking-[0.18em] {{ $mutedTextClasses }}">Profile</p>
                                <p class="mt-1 text-lg font-semibold {{ $headingClasses }}">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="rounded-2xl border px-4 py-3 backdrop-blur {{ $surfaceClasses }}">
                                <p class="text-xs uppercase tracking-[0.18em] {{ $mutedTextClasses }}">Email</p>
                                <p class="mt-1 text-sm font-medium {{ $headingClasses }}">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="rounded-2xl border px-4 py-3 backdrop-blur {{ $surfaceClasses }}">
                                <p class="text-xs uppercase tracking-[0.18em] {{ $mutedTextClasses }}">Security</p>
                                <p class="mt-1 text-sm font-semibold {{ auth()->user()->two_factor_enabled ? 'text-emerald-500' : 'text-amber-500' }}">
                                    {{ auth()->user()->two_factor_enabled ? '2FA Enabled' : '2FA Inactive' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                <nav class="flex flex-wrap gap-2 sm:gap-3">
                    <button @click="tab = 'profile'" :class="tab === 'profile' ? '{{ $tabActiveClasses }}' : '{{ $tabIdleClasses }}'" class="rounded-2xl border px-3 py-2 text-xs font-semibold transition duration-300 ease-out hover:-translate-y-0.5 sm:px-4 sm:text-sm">Profile</button>
                    <button @click="tab = 'security'" :class="tab === 'security' ? '{{ $tabActiveClasses }}' : '{{ $tabIdleClasses }}'" class="rounded-2xl border px-3 py-2 text-xs font-semibold transition duration-300 ease-out hover:-translate-y-0.5 sm:px-4 sm:text-sm">Security</button>
                    <button @click="tab = 'notifications'" :class="tab === 'notifications' ? '{{ $tabActiveClasses }}' : '{{ $tabIdleClasses }}'" class="rounded-2xl border px-3 py-2 text-xs font-semibold transition duration-300 ease-out hover:-translate-y-0.5 sm:px-4 sm:text-sm">Notifications</button>
                    <button @click="tab = 'verification'" :class="tab === 'verification' ? '{{ $tabActiveClasses }}' : '{{ $tabIdleClasses }}'" class="rounded-2xl border px-3 py-2 text-xs font-semibold transition duration-300 ease-out hover:-translate-y-0.5 sm:px-4 sm:text-sm">Verification</button>
                    <button @click="tab = 'preferences'" :class="tab === 'preferences' ? '{{ $tabActiveClasses }}' : '{{ $tabIdleClasses }}'" class="rounded-2xl border px-3 py-2 text-xs font-semibold transition duration-300 ease-out hover:-translate-y-0.5 sm:px-4 sm:text-sm">Preferences</button>
                    <button @click="tab = 'activity'" :class="tab === 'activity' ? '{{ $tabActiveClasses }}' : '{{ $tabIdleClasses }}'" class="rounded-2xl border px-3 py-2 text-xs font-semibold transition duration-300 ease-out hover:-translate-y-0.5 sm:px-4 sm:text-sm">Activity Log</button>
                    <button @click="tab = 'danger'" :class="tab === 'danger' ? '{{ $dangerActiveClasses }}' : '{{ $tabIdleClasses }}'" class="rounded-2xl border px-3 py-2 text-xs font-semibold transition duration-300 ease-out hover:-translate-y-0.5 sm:px-4 sm:text-sm">Danger Zone</button>
                </nav>
            </section>

            <div data-aos="fade-up" data-aos-delay="180" class="space-y-4">
                <div x-show="tab === 'profile'" x-transition.opacity.duration.250ms>
                    @include('user.account-sections.profile')
                </div>
                <div x-show="tab === 'security'" x-transition.opacity.duration.250ms>
                    @include('user.account-sections.security')
                </div>
                <div x-show="tab === 'verification'" x-transition.opacity.duration.250ms>
                    @include('user.account-sections.verification')
                </div>
                <div x-show="tab === 'preferences'" x-transition.opacity.duration.250ms>
                    @include('user.account-sections.preferences')
                </div>
                <div x-show="tab === 'notifications'" x-transition.opacity.duration.250ms>
                    @include('user.account-sections.notifications')
                </div>
                <div x-show="tab === 'activity'" x-transition.opacity.duration.250ms>
                    @include('user.account-sections.activity-log')
                </div>
                <div x-show="tab === 'danger'" x-transition.opacity.duration.250ms>
                    @include('user.account-sections.delete-account')
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
