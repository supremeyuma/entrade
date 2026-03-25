<x-layouts.admin>
    <div class="max-w-xl mx-auto p-4 sm:p-6">
        <h1 class="mb-4 text-lg font-semibold sm:mb-6 sm:text-xl">Add FAQ Category</h1>

        <form action="{{ route('admin.faq-categories.store') }}" method="POST" class="space-y-4 sm:space-y-6">
            @csrf

            <x-inputs.text name="title" label="Title" :value="old('title')" required />

            <x-inputs.select name="icon_type" label="Icon Type" :options="['emoji' => 'Emoji', 'image' => 'Image', 'svg' => 'SVG', 'icon' => 'Font Icon']" :value="old('icon_type')" required />

            <x-inputs.text name="icon_value" label="Icon Value (emoji or path/class)" :value="old('icon_value')" required />

            <x-inputs.text name="slug" label="Slug (optional)" :value="old('slug')" />

            <x-inputs.textarea name="description" label="Description (optional)" :value="old('description')" rows="3" />

            <div class="pt-4">
                <button class="w-full rounded bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700 sm:w-auto">Create Category</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
