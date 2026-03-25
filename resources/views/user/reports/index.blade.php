<x-layouts.app>
<div class="mx-auto mt-4 max-w-3xl px-4 py-6">
    <h4 class="mb-3 text-lg font-semibold sm:text-xl">Generate Report</h4>

    <form action="{{ route('user.reports.generate') }}" method="POST" class="rounded bg-white p-4 shadow sm:p-6">
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
            <button class="w-full rounded bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700 sm:w-auto">Download Report</button>
        </div>
    </form>
</div>
</x-layouts.app>
