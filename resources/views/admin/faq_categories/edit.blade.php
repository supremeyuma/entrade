<x-layouts.admin>
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-xl font-semibold mb-6">Edit FAQ Category</h1>

        <form action="{{ route('admin.faq-categories.update', $faqCategory) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <x-inputs.text name="title" label="Title" :value="$faqCategory->title" required />

            <x-inputs.select name="icon_type" label="Icon Type" :options="['emoji' => 'Emoji', 'image' => 'Image', 'svg' => 'SVG', 'icon' => 'Font Icon']" :value="$faqCategory->icon_type" required />

            <x-inputs.text name="icon_value" label="Icon Value (emoji or path/class)" :value="$faqCategory->icon_value" required />

            <x-inputs.text name="slug" label="Slug (optional)" :value="$faqCategory->slug" />

            <x-inputs.textarea name="description" label="Description (optional)" :value="$faqCategory->description" rows="3" />

            <div class="pt-4">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Update Category</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
