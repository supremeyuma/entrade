<x-layouts/user>
<h2>My Referrals</h2>
    
    <p>Share your referral link: 
        <strong>{{ route('register', ['referral_code' => auth()->id()]) }}</strong>
    </p>

    @if($referrals->count())
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Referred User</th>
                    <th>Date Referred</th>
                </tr>
            </thead>
            <tbody>
                @foreach($referrals as $referral)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $referral->referred->name }}</td>
                        <td>{{ $referral->referred_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You have not referred anyone yet.</p>
    @endif
</x-layouts/user>
