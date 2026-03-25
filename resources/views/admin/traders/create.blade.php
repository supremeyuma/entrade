<x-layouts.admin>
    <div class="px-4 py-6 max-w-3xl mx-auto">
        <h1 class="mb-4 text-xl font-bold sm:mb-6 sm:text-2xl">{{ isset($trader) ? 'Edit Trader' : 'Add Trader' }}</h1>

        <form action="{{ isset($trader) ? route('admin.traders.update', $trader) : route('admin.traders.store') }}"
              method="POST" enctype="multipart/form-data" x-data="previewPhoto()">
            @csrf
            @if(isset($trader)) @method('PUT') @endif

            <div class="mb-4">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $trader->name ?? '') }}" class="input" required>
            </div>

            <div class="mb-4">
                <label>Bio</label>
                <textarea name="bio" class="input" rows="4">{{ old('bio', $trader->bio ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label>Profile Photo</label>
                <input type="file" name="profile_photo" @change="previewImage" class="input">
                <template x-if="imagePreview">
                    <img :src="imagePreview" class="w-24 h-24 mt-3 rounded-full object-cover">
                </template>
                @if(isset($trader) && $trader->profile_photo)
                    <img src="{{ asset('storage/' . $trader->profile_photo) }}" class="w-24 mt-3 rounded">
                @endif
            </div>

            <div class="mb-6 border-t pt-4">
                <h2 class="font-semibold mb-2">Performance Metrics</h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label>Total Trades</label>
                        <input type="number" name="performance[total_trades]" step="1" class="input"
                               value="{{ old('performance.total_trades', $trader->performance_metrics['total_trades'] ?? '') }}">
                    </div>
                    <div>
                        <label>Average ROI (%)</label>
                        <input type="number" name="performance[roi]" step="0.01" class="input"
                               value="{{ old('performance.roi', $trader->performance_metrics['roi'] ?? '') }}">
                    </div>
                    <div>
                        <label>Win Rate (%)</label>
                        <input type="number" name="performance[win_rate]" step="0.01" class="input"
                               value="{{ old('performance.win_rate', $trader->performance_metrics['win_rate'] ?? '') }}">
                    </div>
                    <div>
                        <label>Max Drawdown (%)</label>
                        <input type="number" name="performance[max_drawdown]" step="0.01" class="input"
                               value="{{ old('performance.max_drawdown', $trader->performance_metrics['max_drawdown'] ?? '') }}">
                    </div>
                </div>
            </div>

            <button class="btn btn-primary w-full md:w-auto">
                {{ isset($trader) ? 'Update Trader' : 'Create Trader' }}
            </button>
        </form>
    </div>

    <script>
        function previewPhoto() {
            return {
                imagePreview: null,
                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => this.imagePreview = e.target.result;
                        reader.readAsDataURL(file);
                    }
                }
            };
        }
    </script>
</x-layouts.admin>
