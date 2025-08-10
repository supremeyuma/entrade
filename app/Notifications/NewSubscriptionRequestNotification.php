<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\UserTraderSubscription;

class NewSubscriptionRequestNotification extends Notification
{
    use Queueable;

    public $subscription;

    public function __construct(UserTraderSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Trader Subscription Request')
            ->line('A user has requested to subscribe to a trader.')
            ->line('User: ' . $this->subscription->user->name)
            ->line('Trader: ' . $this->subscription->trader->name)
            ->line('Amount: ' . number_format($this->subscription->allocated_amount, 2))
            ->action('Review Request', route('admin.subscriptions.show', $this->subscription->id));
    }

    public function toArray($notifiable)
    {
        return [
            'subscription_id' => $this->subscription->id,
            'user_name' => $this->subscription->user->name,
            'trader_name' => $this->subscription->trader->name,
            'amount' => $this->subscription->allocated_amount,
        ];
    }
}
