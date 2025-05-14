@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Generate Report</h4>

    <form action="{{ route('user.reports.generate') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Select Sections to Include:</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sections[]" value="deposits" id="deposits">
                <label class="form-check-label" for="deposits">Deposits</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sections[]" value="withdrawals" id="withdrawals">
                <label class="form-check-label" for="withdrawals">Withdrawals</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sections[]" value="trades" id="trades">
                <label class="form-check-label" for="trades">Trades</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sections[]" value="referrals" id="referrals">
                <label class="form-check-label" for="referrals">Referrals</label>
            </div>
        </div>

        <div class="form-group mt-3">
            <button class="btn btn-primary">Download Report</button>
        </div>
    </form>
</div>
@endsection
