@csrf
<div class="space-y-4">
    <div>
        <label class="block font-medium">Category Title</label>
        <input type="text" name="title" value="{{ old('title', $faqCategory->title ?? '') }}"
               class="w-full border border-gray-300 rounded px-4 py-2">
    </div>
</div>
