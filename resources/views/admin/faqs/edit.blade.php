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
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Edit FAQ</h1>
                        <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Update content, ordering, and featured visibility without crowding the mobile form.</p>
                    </div>
                    <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center justify-center rounded-2xl border px-4 py-2 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-900/80 text-slate-100 hover:bg-slate-800' : 'border-slate-300 bg-white/80 text-slate-900 hover:bg-slate-50' }}">
                        Back to FAQs
                    </a>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form action="{{ route('admin.faqs.update', $faq) }}" method="POST" class="space-y-4 sm:space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-4 lg:grid-cols-[1.1fr_0.9fr]">
                    <div class="space-y-4">
                        <div>
                            <label for="faq_category_id" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Category</label>
                            <select id="faq_category_id" name="faq_category_id" required class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('faq_category_id', $faq->faq_category_id) == $category->id)>{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error('faq_category_id')
                                <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="question" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Question</label>
                            <input id="question" type="text" name="question" value="{{ old('question', $faq->question) }}" required class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" placeholder="Enter the FAQ question">
                            @error('question')
                                <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="rounded-3xl border p-4 sm:p-5 {{ $isDark ? 'border-slate-700 bg-slate-800/70' : 'border-slate-200 bg-slate-50/80' }}">
                        <div class="space-y-4">
                            <div>
                                <label for="position" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Position</label>
                                <input id="position" type="number" name="position" value="{{ old('position', $faq->position ?? 0) }}" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                                @error('position')
                                    <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="is_featured" class="flex items-center justify-between gap-3 rounded-2xl border px-3 py-3 text-sm transition {{ $isDark ? 'border-slate-700 bg-slate-900/70' : 'border-slate-200 bg-white' }}">
                                <span>
                                    <span class="block font-medium {{ $headingClasses }}">Featured</span>
                                    <span class="block text-xs {{ $mutedTextClasses }}">Pin this item for quicker discovery.</span>
                                </span>
                                <input id="is_featured" type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" {{ old('is_featured', $faq->is_featured ? 1 : 0) ? 'checked' : '' }}>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="answer" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Answer</label>
                    <input id="answer" type="hidden" name="answer" value="{{ old('answer', $faq->answer ?? '') }}">
                    <trix-editor input="answer" class="trix-content min-h-[220px] rounded-[22px] border px-3 py-3 text-sm shadow-sm transition focus-within:ring-2 {{ $inputClasses }}"></trix-editor>
                    @error('answer')
                        <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center justify-center rounded-2xl border px-4 py-2.5 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-800 text-slate-100 hover:bg-slate-700' : 'border-slate-300 bg-white text-slate-900 hover:bg-slate-50' }}">
                        Cancel
                    </a>
                    <button class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">
                        Update FAQ
                    </button>
                </div>
            </form>
        </section>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.0.0/dist/trix.css">
    <script src="https://cdn.jsdelivr.net/npm/trix@2.0.0/dist/trix.umd.min.js"></script>
</x-layouts.admin>
