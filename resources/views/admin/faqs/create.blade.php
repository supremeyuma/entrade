<x-layouts.admin>
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-xl font-semibold mb-6">Add FAQ Category</h1>

        <form action="{{ route('admin.faq-categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-inputs.text name="title" label="Title" :value="old('title')" required />

            <x-inputs.select name="icon_type" label="Icon Type" :options="['emoji' => 'Emoji', 'image' => 'Image', 'svg' => 'SVG', 'icon' => 'Font Icon']" :value="old('icon_type')" required />

            <x-inputs.text name="icon_value" label="Icon Value (emoji or path/class)" :value="old('icon_value')" required />

            <x-inputs.text name="slug" label="Slug (optional)" :value="old('slug')" />

            <x-inputs.textarea name="description" label="Description (optional)" :value="old('description')" rows="3" />

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
</x-layouts.admin>
