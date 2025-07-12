<x-layouts.admin>
    <div class="max-w-5xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">FAQ Categories</h1>
        <a href="{{ route('admin.faq-categories.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Add Category</a>
    </div>
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        

        <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
                <thead>
                    <tr class="text-left text-sm text-gray-600 dark:text-gray-300">
                        <th class="py-2">Icon</th>
                        <th class="p-3">Title</th>
                        <th class="p-3">Slug</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $cat)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="py-2 text-2xl">
                                @if($cat->icon_type === 'emoji')
                                    {{ $cat->icon_value }}
                                @elseif($cat->icon_type === 'image')
                                    <img src="{{ asset($cat->icon_value) }}" class="w-6 h-6 inline" alt="Icon">
                                @elseif($cat->icon_type === 'svg')
                                    <svg class="w-6 h-6 inline">{!! file_get_contents(public_path($cat->icon_value)) !!}</svg>
                                @elseif($cat->icon_type === 'icon')
                                    <i class="{{ $cat->icon_value }}"></i>
                                @endif
                            </td>
                            <td>{{ $cat->title }}</td>
                            <td class="p-3 text-sm text-gray-500">{{ $cat->slug }}</td>
                            <td class="p-3 text-right">
                                <a href="{{ route('admin.faq-categories.edit', $cat) }}" class="text-indigo-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('admin.faq-categories.destroy', $cat) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure?')">
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

