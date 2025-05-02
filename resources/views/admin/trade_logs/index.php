@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl mb-4">Trade Logs</h1>

    <a href="{{ route('admin.trade-logs.create') }}" class="btn btn-primary mb-4">Add Trade Log</a>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Trader</th>
                <th>Date</th>
                <th>Result</th>
                <th>Change %</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tradeLogs as $log)
                <tr>
                    <td>{{ $log->trader->name }}</td>
                    <td>{{ $log->entry_date->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($log->result) }}</td>
                    <td>{{ $log->percentage_change }}%</td>
                    <td>{{ Str::limit($log->notes, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.trade-logs.edit', $log) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.trade-logs.destroy', $log) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
