<x-layouts.admin>
<h1 class="text-2xl mb-4">Traders</h1>

    <a href="{{ route('admin.traders.create') }}" class="btn btn-primary mb-4">Add Trader</a>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Name</th>
                <th>Bio</th>
                <th>Performance</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($traders as $trader)
                <tr>
                    <td>{{ $trader->name }}</td>
                    <td>{{ Str::limit($trader->bio, 50) }}</td>
                    <td><pre>{{ json_encode($trader->performance_metrics, JSON_PRETTY_PRINT) }}</pre></td>
                    <td>
                        @if($trader->profile_photo)
                            <img src="{{ asset('storage/' . $trader->profile_photo) }}" alt="Photo" class="w-16 h-16 object-cover rounded">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.traders.edit', $trader) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.traders.destroy', $trader) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.admin>
