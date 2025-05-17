@extends('layouts.admin')

@section('content')
    <h2>All Referrals</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Referrer</th>
                <th>Referred User</th>
                <th>Referred At</th>
                <th>Status</th>
                <th>Action</th> <!-- 👈 added Action column -->
            </tr>
        </thead>
        <tbody>
            @foreach($referrals as $referral)
                <tr>
                    <td>{{ $referral->id }}</td>
                    <td>{{ $referral->referrer->name }} (ID: {{ $referral->referrer_id }})</td>
                    <td>{{ $referral->referred->name }} (ID: {{ $referral->referred_id }})</td>
                    <td>{{ $referral->referred_at->format('d M Y H:i') }}</td>
                    <td>{{ ucfirst($referral->status) }}</td>
                    <td>
                        @if($referral->status == 'pending')
                            <form action="{{ route('admin.referrals.approve', $referral->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">Approve & Pay</button>
                            </form>
                        @else
                            <span>-</span>
                        @endif
                    </td> <!-- 👈 approval button placed here -->
                </tr>
            @endforeach
        </tbody>
    </table>


    {{ $referrals->links() }}
@endsection
