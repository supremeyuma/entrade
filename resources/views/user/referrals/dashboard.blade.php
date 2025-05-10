@extends('layout.user')

@section('content')
    <h2>My Referrals</h2>
    
    <p>Share this link to invite others: <strong>{{ auth()->user()->referral_link }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Referred User</th>
                <th>Date Referred</th>
            </tr>
        </thead>
        <tbody>
            @foreach(auth()->user()->referralsMade as $referral)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $referral->referred->name }}</td>
                    <td>{{ $referral->referred_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
