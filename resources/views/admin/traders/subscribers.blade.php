<x-layouts.app>
<h1>Subscribers for {{ $trader->name }}</h1>

    <table class="table">
        <thead>
            <tr><th>User</th><th>Subscribed At</th><th>Allocated Amount</th></tr>
        </thead>
        <tbody>
            @foreach ($subscribers as $subscription)
                <tr>
                    <td>{{ $subscription->user->name }}</td>
                    <td>{{ $subscription->created_at }}</td>
                    <td>{{ $subscription->allocated_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $subscribers->links() }}
</x-layouts.app>
