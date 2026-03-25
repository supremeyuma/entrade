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
    @endphp

    <div class="space-y-3 sm:space-y-6">
        <section data-aos="fade-up" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">FAQ Categories</h1>
                        <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Organize FAQs into visual groups with icons and mobile-friendly actions.</p>
                    </div>
                    <a href="{{ route('admin.faq-categories.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                        Add Category
                    </a>
                </div>
            </div>
        </section>

        @if (session('success'))
            <div data-aos="fade-up" data-aos-delay="80" class="rounded-[20px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <section data-aos="fade-up" data-aos-delay="140" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="min-w-full text-sm">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr class="text-left uppercase text-[11px] tracking-[0.16em]">
                        <th class="px-3 py-2.5 sm:px-4">Icon</th>
                        <th class="px-3 py-2.5 sm:px-4">Title</th>
                        <th class="px-3 py-2.5 sm:px-4">Slug</th>
                        <th class="px-3 py-2.5 sm:px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @forelse ($categories as $cat)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 sm:px-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl {{ $isDark ? 'bg-slate-800 text-slate-100' : 'bg-slate-100 text-slate-900' }}">
                                    @if ($cat->icon_type === 'emoji')
                                        <span class="text-xl">{{ $cat->icon_value }}</span>
                                    @elseif ($cat->icon_type === 'image')
                                        <img src="{{ asset($cat->icon_value) }}" class="h-6 w-6" alt="Icon">
                                    @elseif ($cat->icon_type === 'svg')
                                        <span class="inline-flex h-6 w-6 items-center justify-center">{!! file_get_contents(public_path($cat->icon_value)) !!}</span>
                                    @elseif ($cat->icon_type === 'icon')
                                        <i class="{{ $cat->icon_value }}"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3 sm:px-4">
                                <p class="font-semibold">{{ $cat->title }}</p>
                                <p class="text-xs {{ $mutedTextClasses }}">{{ ucfirst($cat->icon_type) }}</p>
                            </td>
                            <td class="px-3 py-3 text-xs sm:px-4 sm:text-sm {{ $mutedTextClasses }}">{{ $cat->slug }}</td>
                            <td class="px-3 py-3 text-right sm:px-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.faq-categories.edit', $cat) }}" class="inline-flex items-center rounded-2xl bg-sky-600 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.faq-categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center rounded-2xl bg-rose-600 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-sm {{ $mutedTextClasses }}">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
</x-layouts.admin>
