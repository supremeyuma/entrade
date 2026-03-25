@csrf

@php
    $isDark = session('theme', 'light') === 'dark';
    $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
    $inputClasses = $isDark
        ? 'border-slate-700 bg-slate-800 text-slate-100 placeholder:text-slate-500 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label for="title" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Title</label>
        <input
            id="title"
            type="text"
            name="title"
            value="{{ old('title', $faqCategory->title ?? '') }}"
            class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}"
            placeholder="Category title"
        >
    </div>

    <div>
        <label for="icon" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Icon</label>
        <input
            id="icon"
            type="text"
            name="icon"
            value="{{ old('icon', $faqCategory->icon ?? '') }}"
            class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}"
            placeholder="e.g. rocket or heroicon-chart-bar"
        >
    </div>
</div>
