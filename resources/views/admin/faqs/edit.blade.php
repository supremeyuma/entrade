<x-layouts.admin>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-xl font-semibold mb-6">Edit FAQ</h1>

        <form action="{{ route('admin.faqs.update', $faq) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <x-inputs.select name="faq_category_id" label="Category" :options="$categories->pluck('title', 'id')" :value="$faq->faq_category_id" required />

            <x-inputs.text name="question" label="Question" :value="$faq->question" required />

            <x-inputs.textarea name="answer" label="Answer" :value="$faq->answer" rows="5" required />

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
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Update FAQ</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
