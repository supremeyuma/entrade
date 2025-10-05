<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChargeUrlMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $charge_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($charge_url)
    {
        $this->charge_url = $charge_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Charge Url')
                    ->view('emails.charge_url');
    }
}
