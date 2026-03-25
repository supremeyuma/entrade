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

    <div class="space-y-3 sm:space-y-6">
        <section data-aos="fade-up" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Add FAQ Category</h1>
                        <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Create a clean category card with icon metadata and compact mobile spacing.</p>
                    </div>
                    <a href="{{ route('admin.faq-categories.index') }}" class="inline-flex items-center justify-center rounded-2xl border px-4 py-2 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-900/80 text-slate-100 hover:bg-slate-800' : 'border-slate-300 bg-white/80 text-slate-900 hover:bg-slate-50' }}">
                        Back to Categories
                    </a>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form action="{{ route('admin.faq-categories.store') }}" method="POST" class="space-y-4 sm:space-y-5">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="title" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Title</label>
                        <input id="title" type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" placeholder="Category title">
                        @error('title')
                            <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Slug</label>
                        <input id="slug" type="text" name="slug" value="{{ old('slug') }}" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" placeholder="optional-category-slug">
                        @error('slug')
                            <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="icon_type" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Icon Type</label>
                        <select id="icon_type" name="icon_type" required class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                            <option value="emoji" @selected(old('icon_type') === 'emoji')>Emoji</option>
                            <option value="image" @selected(old('icon_type') === 'image')>Image</option>
                            <option value="svg" @selected(old('icon_type') === 'svg')>SVG</option>
                            <option value="icon" @selected(old('icon_type') === 'icon')>Font Icon</option>
                        </select>
                        @error('icon_type')
                            <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="icon_value" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Icon Value</label>
                        <input id="icon_value" type="text" name="icon_value" value="{{ old('icon_value') }}" required class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" placeholder="e.g. rocket, /images/icon.svg, fa-solid fa-chart-line">
                        @error('icon_value')
                            <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full rounded-[22px] border px-3 py-3 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" placeholder="Optional summary shown alongside this category.">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.faq-categories.index') }}" class="inline-flex items-center justify-center rounded-2xl border px-4 py-2.5 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-800 text-slate-100 hover:bg-slate-700' : 'border-slate-300 bg-white text-slate-900 hover:bg-slate-50' }}">
                        Cancel
                    </a>
                    <button class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                        Create Category
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-layouts.admin>
