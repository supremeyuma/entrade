@extends('layouts.admin')

@section('content')
    <h1 class="text-xl font-bold mb-4">All Users</h1>

    @if(session('success'))
        <div class="p-2 bg-green-200 text-green-800 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border rounded">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Role</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="px-4 py-2 border">{{ $user->id }}</td>
                    <td class="px-4 py-2 border">{{ $user->name }}</td>
                    <td class="px-4 py-2 border">{{ $user->email }}</td>
                    <td class="px-4 py-2 border">
                        {{ $user->roles->pluck('name')->implode(', ') ?: 'No role' }}
                    </td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('admin.users.editRole', $user) }}" class="text-blue-600 hover:underline">Edit Role</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection
