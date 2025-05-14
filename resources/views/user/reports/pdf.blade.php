<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h3 { margin-top: 40px; }
    </style>
</head>
<body>
    <h2>User Report for {{ $user->name }}</h2>

    @if(!empty($data['deposits']))
        <h3>Deposits</h3>
        <table>
            <thead><tr><th>#</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($data['deposits'] as $d)
                    <tr><td>{{ $loop->iteration }}</td><td>{{ $d->amount }}</td><td>{{ ucfirst($d->status) }}</td><td>{{ $d->created_at }}</td></tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($data['withdrawals']))
        <h3>Withdrawals</h3>
        <table>
            <thead><tr><th>#</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($data['withdrawals'] as $w)
                    <tr><td>{{ $loop->iteration }}</td><td>{{ $w->amount }}</td><td>{{ ucfirst($w->status) }}</td><td>{{ $w->created_at }}</td></tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($data['trades']))
        <h3>Trades</h3>
        <table>
            <thead><tr><th>#</th><th>Trader</th><th>Amount</th><th>ROI</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($data['trades'] as $t)
                    <tr><td>{{ $loop->iteration }}</td><td>{{ $t->trader->name ?? 'N/A' }}</td><td>{{ $t->amount }}</td><td>{{ $t->roi }}%</td><td>{{ $t->created_at }}</td></tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($data['referrals']))
        <h3>Referrals</h3>
        <table>
            <thead><tr><th>#</th><th>Referred User</th><th>Status</th><th>Bonus</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($data['referrals'] as $r)
                    <tr><td>{{ $loop->iteration }}</td><td>{{ $r->referred->name ?? 'N/A' }}</td><td>{{ ucfirst($r->status) }}</td><td>{{ $r->bonus_amount }}</td><td>{{ $r->created_at }}</td></tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
