<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $fields = [];


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->fields = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("PorstLogin@yandex.ru")
                    ->view("emails/send-email")
                    ->with($this->fields)
                    ->subject("Новое письмо");
    }
}
