<?php

namespace App\Notifications;

use App\Models\TradeOutcome;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TradeOutcomeNotification extends Notification
{
    use Queueable;

    protected $tradeOutcome;
    protected $gainLoss;

    public function __construct(TradeOutcome $tradeOutcome, $gainLoss)
    {
        $this->tradeOutcome = $tradeOutcome;
        $this->gainLoss = $gainLoss;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // or just 'database' if you don’t want email
    }

    public function toMail($notifiable)
    {
        $amountFormatted = number_format($this->gainLoss, 2);
        $traderName = $this->tradeOutcome->trader->name;

        return (new MailMessage)
            ->subject('Trade Outcome Update')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("Your copy trading with trader **{$traderName}** has resulted in a change of **{$amountFormatted}**.")
            ->line('Thank you for trading with us!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'trade_outcome_id' => $this->tradeOutcome->id,
            'trader_id' => $this->tradeOutcome->trader_id,
            'trader_name' => $this->tradeOutcome->trader->name,
            'percentage_change' => $this->tradeOutcome->percentage_change,
            'gain_loss' => $this->gainLossAmount,
            'url' => route('user.trade.outcome.show', ['id' => $this->tradeOutcome->id]),
        ];
    }

}
