<x-layouts.admin>
    <div class="max-w-6xl mx-auto p-6" x-data="{ search: '' }">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">FAQs</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.faqs.export.csv') }}" class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">Export CSV</a>
                <a href="{{ route('admin.faqs.export.json') }}" class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">Export JSON</a>
                <form action="{{ route('admin.faqs.import') }}" method="POST" enctype="multipart/form-data" class="inline-flex space-x-2">
                    @csrf
                    <input type="file" name="file" required class="text-sm">
                    <button class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">Import</button>
                </form>
                <a href="{{ route('admin.faqs.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Add FAQ
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif


        {{-- 🔍 Search --}}
        <div class="mb-4">
            <input
                type="text"
                placeholder="Search FAQs..."
                class="w-full px-4 py-2 border rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                x-model="search"
            />
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
                <thead>
                    <tr class="text-left text-sm text-gray-600 dark:text-gray-300">
                        <th class="py-2 px-3">Pos</th>
                        <th class="py-2 px-3">Question</th>
                        <th class="py-2 px-3">Category</th>
                        <th class="py-2 px-3">Featured</th>
                        <th class="py-2 px-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="faq-sortable">
                    @foreach ($faqs as $faq)
                        <tr class="border-t border-gray-200 dark:border-gray-700 cursor-move"
                            data-id="{{ $faq->id }}" draggable="true"
                            x-show="search === '' || '{{ strtolower($faq->question) }}'.includes(search.toLowerCase())"
                        >
                        <td class="py-2 px-3 font-medium">{{ $faq->position }}</td>
                            <td class="py-2 px-3 font-medium">{{ $faq->question }}</td>
                            <td class="py-2 px-3 text-sm">{{ $faq->category->title ?? '-' }}</td>
                            <td class="py-2 px-3 text-sm ">
                            <button 
                                x-data="{ featured: {{ $faq->is_featured ? 'true' : 'false' }} }"
                                @click.prevent="
                                    fetch('{{ route('admin.faqs.toggle-featured', $faq) }}', {
                                        method: 'PATCH',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    }).then(response => response.json())
                                    .then(data => { featured = data.is_featured })
                                "
                                class="w-10 h-6 rounded-full transition duration-300 flex items-center justify-start"
                                :class="featured ? 'bg-indigo-600' : 'bg-gray-300'"
                                :aria-pressed="featured.toString()"
                            >
                                <div class="w-4 h-4 bg-white rounded-full shadow transform transition duration-200"
                                    :class="featured ? 'translate-x-4' : 'translate-x-1'"></div>
                            </button>
                            </td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-indigo-600 hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($faqs->isEmpty())
                        <tr><td colspan="3" class="p-4 text-center text-gray-500 dark:text-gray-400">No FAQs found.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        new Sortable(document.getElementById('faq-sortable'), {
            animation: 150,
            ghostClass: 'bg-yellow-100', // Optional: visual feedback
            handle: null,                // No handle needed; whole row draggable
            draggable: 'tr',             // Important: make rows draggable
            onEnd: function () {
                const order = Array.from(document.querySelectorAll('#faq-sortable tr')).map(row => row.dataset.id);
                console.log('Submitting reorder:', order); // ✅ Check this appears in Console

                fetch('{{ route('admin.faqs.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ order })
                }).then(response => response.json())
                .then(data => console.log('Reorder response:', data))
                .catch(err => console.error('Reorder failed', err))
                .then(() => {
                    // Update the position numbers directly in the DOM
                    document.querySelectorAll('#faq-sortable tr').forEach((row, index) => {
                        row.querySelector('td').textContent = index + 1;
                    });
                });
            }
        });
    </script>

</x-layouts.admin>