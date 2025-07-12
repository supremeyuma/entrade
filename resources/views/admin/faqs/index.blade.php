<x-layouts.admin>
    <div class="max-w-6xl mx-auto p-6">
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
                <tbody>
                    @foreach ($faqs as $faq)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="py-2 px-3 font-medium">{{ $faq->position }}</td>
                            <td class="py-2 px-3 font-medium">{{ $faq->question }}</td>
                            <td class="py-2 px-3 text-sm">{{ $faq->category->title ?? '-' }}</td>
                            <td class="py-2 px-3 text-sm ">
                                @if($faq->is_featured)
                                    <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded">Yes</span>
                                @else
                                    <span class="text-gray-400 text-xs">No</span>
                                @endif
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
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
