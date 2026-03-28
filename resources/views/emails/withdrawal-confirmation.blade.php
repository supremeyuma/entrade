<p>Hi {{ $withdrawal->user->name }},</p>

<p>You requested a withdrawal of ${{ number_format($withdrawal->usd_amount ?? $withdrawal->amount, 2) }} USD.</p>

<p>This converts to approximately {{ number_format($withdrawal->amount, 8, '.', ',') }} {{ $withdrawal->cryptocurrency }} at a rate of 1 {{ $withdrawal->cryptocurrency }} = ${{ number_format($withdrawal->exchange_rate ?? 0, 2, '.', ',') }}.</p>

<p>To confirm, click below:</p>

<a href="{{ route('user.withdrawals.confirm', $withdrawal->confirmation_token) }}"
   style="background: #2563eb; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">
    Confirm Withdrawal
</a>

<p>If you didn't request this, please ignore this email.</p>
