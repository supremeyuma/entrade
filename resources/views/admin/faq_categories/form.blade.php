@csrf
<div class="space-y-4">
    <div>
        <label class="block font-medium">Title</label>
        <input type="text" name="title" value="{{ old('title', $faqCategory->title ?? '') }}"
               class="w-full border border-gray-300 rounded px-4 py-2">
    </div>
    <div>
        <label class="block font-medium">Icon (emoji or SVG class)</label>
        <input type="text" name="icon" value="{{ old('icon', $faqCategory->icon ?? '') }}"
               class="w-full border border-gray-300 rounded px-4 py-2" placeholder="e.g. 🚀 or heroicon-chart-bar">
    </div>
</div>
