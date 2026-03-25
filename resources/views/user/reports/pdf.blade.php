<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #0f172a;
            margin: 32px;
        }

        .heading {
            margin-bottom: 18px;
        }

        .eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #64748b;
        }

        h2 {
            margin: 6px 0 4px;
            font-size: 22px;
        }

        p.meta {
            margin: 0;
            color: #475569;
        }

        h3 {
            margin-top: 34px;
            margin-bottom: 10px;
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 7px 8px;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #334155;
        }
    </style>
</head>
<body>
    <div class="heading">
        <div class="eyebrow">User Report</div>
        <h2>{{ $user->name }}</h2>
        <p class="meta">Generated account summary report</p>
    </div>

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
