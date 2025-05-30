<x-layouts/app>
<h1>Trades for {{ $trader->name }}</h1>

    <table class="table">
        <thead>
            <tr><th>Date</th><th>Outcome</th><th>% Gain/Loss</th></tr>
        </thead>
        <tbody>
            @foreach ($trades as $trade)
                <tr>
                    <td>{{ $trade->created_at }}</td>
                    <td>{{ $trade->outcome }}</td>
                    <td>{{ $trade->percentage }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $trades->links() }}
</x-layouts/app>
