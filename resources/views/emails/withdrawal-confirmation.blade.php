<p>Hi {{ $withdrawal->user->name }},</p>

<p>You requested a withdrawal of {{ $withdrawal->amount }} {{ $withdrawal->cryptocurrency }}.</p>

<p>To confirm, click below:</p>

<a href="{{ route('user.withdrawals.confirm', $withdrawal->confirmation_token) }}"
   style="background: #2563eb; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">
    Confirm Withdrawal
</a>

<p>If you didn't request this, please ignore this email.</p>
