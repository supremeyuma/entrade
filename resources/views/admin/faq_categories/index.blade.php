@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">FAQ Categories</h1>
        <a href="{{ route('admin.faq-categories.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Add Category</a>
    </div>

    <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
        <thead>
            <tr class="text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                <th class="p-3">Title</th>
                <th class="p-3">Slug</th>
                <th class="p-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="text-sm text-gray-700 dark:text-gray-200">
            @foreach($categories as $category)
                <tr class="border-t border-gray-200 dark:border-gray-700">
                    <td class="p-3">{{ $category->title }}</td>
                    <td class="p-3 text-sm text-gray-500">{{ $category->slug }}</td>
                    <td class="p-3 text-right">
                        <a href="{{ route('admin.faq-categories.edit', $category) }}" class="text-indigo-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('admin.faq-categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this category?')" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
