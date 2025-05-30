@extends('layouts.admin')

@section('content')
    <h1>Activity Logs</h1>

    <form method="GET">
        <input type="text" name="user_id" placeholder="User ID" value="{{ request('user_id') }}">
        <input type="text" name="action_type" placeholder="Action Type" value="{{ request('action_type') }}">
        <button type="submit">Filter</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>User</th><th>Action</th><th>Description</th><th>Metadata</th><th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->user?->name ?? 'System' }}</td>
                    <td>{{ $log->action_type }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ json_encode($log->metadata) }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $logs->links() }}
@endsection
