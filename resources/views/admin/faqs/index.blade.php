<x-layouts.admin>
    <div class="max-w-6xl mx-auto p-4 sm:p-6" x-data="{ search: '' }">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-xl font-bold sm:text-2xl">FAQs</h1>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.faqs.export.csv') }}" class="rounded-2xl bg-sky-600 px-3 py-2 text-sm font-semibold text-white">Export CSV</a>
                <a href="{{ route('admin.faqs.export.json') }}" class="rounded-2xl bg-sky-600 px-3 py-2 text-sm font-semibold text-white">Export JSON</a>
                <form action="{{ route('admin.faqs.import') }}" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-2">
                    @csrf
                    <input type="file" name="file" required class="text-sm">
                    <button class="rounded-2xl bg-sky-600 px-3 py-2 text-sm font-semibold text-white">Import</button>
                </form>
                <a href="{{ route('admin.faqs.create') }}" class="rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Add FAQ</a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-2xl bg-emerald-50 p-4 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
        @endif

        <div class="mb-4">
            <input type="text" placeholder="Search FAQs..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm shadow-sm focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-800" x-model="search" />
        </div>

        <div class="rounded-[20px] border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="min-w-full overflow-hidden rounded bg-white text-sm shadow dark:bg-slate-900">
                    <thead>
                        <tr class="text-left text-sm text-slate-600 dark:text-slate-300">
                            <th class="px-3 py-2">Pos</th>
                            <th class="px-3 py-2">Question</th>
                            <th class="px-3 py-2">Category</th>
                            <th class="px-3 py-2">Featured</th>
                            <th class="px-3 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="faq-sortable">
                        @foreach ($faqs as $faq)
                            <tr class="cursor-move border-t border-slate-200 dark:border-slate-700" data-id="{{ $faq->id }}" draggable="true" x-show="search === '' || '{{ strtolower($faq->question) }}'.includes(search.toLowerCase())">
                                <td class="px-3 py-2 font-medium">{{ $faq->position }}</td>
                                <td class="px-3 py-2 font-medium">{{ $faq->question }}</td>
                                <td class="px-3 py-2 text-sm">{{ $faq->category->title ?? '-' }}</td>
                                <td class="px-3 py-2 text-sm">
                                    <button x-data="{ featured: {{ $faq->is_featured ? 'true' : 'false' }} }" @click.prevent="
                                            fetch('{{ route('admin.faqs.toggle-featured', $faq) }}', {
                                                method: 'PATCH',
                                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                                            }).then(response => response.json()).then(data => { featured = data.is_featured })"
                                        class="flex h-6 w-10 items-center justify-start rounded-full transition duration-300" :class="featured ? 'bg-sky-600' : 'bg-slate-300 dark:bg-slate-700'">
                                        <div class="h-4 w-4 rounded-full bg-white shadow transition duration-200" :class="featured ? 'translate-x-4' : 'translate-x-1'"></div>
                                    </button>
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-right">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="mr-3 text-sky-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
                                        @csrf @method('DELETE')
                                        <button class="text-rose-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($faqs->isEmpty())
                            <tr><td colspan="5" class="p-4 text-center text-slate-500 dark:text-slate-400">No FAQs found.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        new Sortable(document.getElementById('faq-sortable'), {
            animation: 150,
            ghostClass: 'bg-yellow-100',
            handle: null,
            draggable: 'tr',
            onEnd: function () {
                const order = Array.from(document.querySelectorAll('#faq-sortable tr')).map(row => row.dataset.id);
                fetch('{{ route('admin.faqs.reorder') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order })
                }).then(() => {
                    document.querySelectorAll('#faq-sortable tr').forEach((row, index) => {
                        row.querySelector('td').textContent = index + 1;
                    });
                });
            }
        });
    </script>
</x-layouts.admin>
