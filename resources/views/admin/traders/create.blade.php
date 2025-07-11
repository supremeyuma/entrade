<x-layouts.admin>
<h1 class="text-2xl mb-4">{{ isset($trader) ? 'Edit' : 'Add' }} Trader</h1>

    <form action="{{ isset($trader) ? route('admin.traders.update', $trader) : route('admin.traders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($trader))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $trader->name ?? '') }}" required class="input">
        </div>

        <div class="mb-4">
            <label>Bio</label>
            <textarea name="bio" class="input">{{ old('bio', $trader->bio ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label>Performance Metrics (JSON)</label>
            <textarea name="performance_metrics" class="input">{{ old('performance_metrics', isset($trader) ? json_encode($trader->performance_metrics) : '') }}</textarea>
        </div>

        <div class="mb-4">
            <label>Profile Photo</label>
            <input type="file" name="profile_photo" class="input">
            @if(isset($trader) && $trader->profile_photo)
                <img src="{{ asset('storage/' . $trader->profile_photo) }}" class="w-24 mt-2 rounded">
            @endif
        </div>

        <button class="btn btn-primary">{{ isset($trader) ? 'Update' : 'Create' }}</button>
    </form>
</x-layouts.admin>
