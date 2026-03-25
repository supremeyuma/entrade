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
            ? 'border-slate-700 bg-slate-800 text-slate-100 placeholder:text-slate-500 focus:border-emerald-400 focus:ring-emerald-500/20'
            : 'border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 focus:border-emerald-400 focus:ring-emerald-200';
    @endphp

    <div class="space-y-3 sm:space-y-6" x-data="previewPhoto()">
        <section data-aos="fade-up" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Edit Trader</h1>
                        <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Update the trader profile, metrics, and profile image in the same compact admin layout.</p>
                    </div>
                    <a href="{{ route('admin.traders.index') }}" class="inline-flex items-center justify-center rounded-2xl border px-4 py-2 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-900/80 text-slate-100 hover:bg-slate-800' : 'border-slate-300 bg-white/80 text-slate-900 hover:bg-slate-50' }}">
                        Back to Traders
                    </a>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form action="{{ route('admin.traders.update', $trader) }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-4 lg:grid-cols-[1.2fr_0.8fr]">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $trader->name ?? '') }}" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" required>
                        </div>

                        <div>
                            <label for="bio" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Bio</label>
                            <textarea id="bio" name="bio" rows="5" class="w-full rounded-[22px] border px-3 py-3 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">{{ old('bio', $trader->bio ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="rounded-3xl border p-4 sm:p-5 {{ $isDark ? 'border-slate-700 bg-slate-800/70' : 'border-slate-200 bg-slate-50/80' }}">
                        <label for="profile_photo" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Profile Photo</label>
                        <input id="profile_photo" type="file" name="profile_photo" @change="previewImage" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition file:mr-3 file:rounded-xl file:border-0 file:bg-sky-600 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white {{ $inputClasses }}">

                        <div class="mt-4 flex items-center justify-center rounded-3xl border border-dashed p-4 {{ $isDark ? 'border-slate-700 bg-slate-900/70' : 'border-slate-300 bg-white' }}">
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="h-24 w-24 rounded-full object-cover shadow-md">
                            </template>
                            <template x-if="!imagePreview">
                                <div class="text-center">
                                    @if (isset($trader) && $trader->profile_photo)
                                        <img src="{{ asset('storage/' . $trader->profile_photo) }}" class="h-24 w-24 rounded-full object-cover shadow-md">
                                    @else
                                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full {{ $isDark ? 'bg-slate-800 text-slate-400' : 'bg-slate-100 text-slate-500' }}">No image</div>
                                    @endif
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-4 {{ $isDark ? 'border-slate-800' : 'border-slate-200' }}">
                    <h2 class="text-lg font-semibold {{ $headingClasses }}">Performance Metrics</h2>
                    <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">These values feed the trader overview and leaderboard summaries.</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Total Trades</label>
                            <input type="number" name="performance[total_trades]" step="1" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" value="{{ old('performance.total_trades', $trader->performance_metrics['total_trades'] ?? '') }}">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Average ROI (%)</label>
                            <input type="number" name="performance[roi]" step="0.01" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" value="{{ old('performance.roi', $trader->performance_metrics['roi'] ?? '') }}">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Win Rate (%)</label>
                            <input type="number" name="performance[win_rate]" step="0.01" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" value="{{ old('performance.win_rate', $trader->performance_metrics['win_rate'] ?? '') }}">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Max Drawdown (%)</label>
                            <input type="number" name="performance[max_drawdown]" step="0.01" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" value="{{ old('performance.max_drawdown', $trader->performance_metrics['max_drawdown'] ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.traders.index') }}" class="inline-flex items-center justify-center rounded-2xl border px-4 py-2.5 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-800 text-slate-100 hover:bg-slate-700' : 'border-slate-300 bg-white text-slate-900 hover:bg-slate-50' }}">
                        Cancel
                    </a>
                    <button class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">
                        Update Trader
                    </button>
                </div>
            </form>
        </section>
    </div>

    <script>
        function previewPhoto() {
            return {
                imagePreview: null,
                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => this.imagePreview = e.target.result;
                        reader.readAsDataURL(file);
                    }
                }
            };
        }
    </script>
</x-layouts.admin>
