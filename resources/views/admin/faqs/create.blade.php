<x-layouts.admin>
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-xl font-semibold mb-6">Create FAQ</h1>

        <form action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-inputs.select name="faq_category_id" label="Category" :options="$categories->pluck('title', 'id')" required />

            <x-inputs.text name="question" label="Question" required />

            <div>
                <label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Answer</label>
                <input id="answer" type="hidden" name="answer" value="{{ old('answer', $faq->answer ?? '') }}">
                <trix-editor input="answer" class="mt-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded shadow-sm"></trix-editor>
                @error('answer')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-inputs.text name="position" label="Position" type="number" :value="$faq->position ?? 0" />

                <div class="flex items-center mt-6">
                    <input type="checkbox" name="is_featured" id="is_featured" value = "1"
                        class="rounded text-indigo-600 shadow-sm border-gray-300"
                        {{ (isset($faq) && $faq->is_featured) ? 'checked' : '' }}>
                    <label for="is_featured" class="ml-2 text-sm text-gray-700">Featured</label>
                </div>
            </div>


            <div class="pt-4">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Create Category</button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.0.0/dist/trix.css">
  
    <script src="https://cdn.jsdelivr.net/npm/trix@2.0.0/dist/trix.umd.min.js"></script>
    
</x-layouts.admin>
