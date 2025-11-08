<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public ContactMessage $messageModel;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $messageModel)
    {
        $this->messageModel = $messageModel;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this
            ->subject('Новое сообщение с сайта GreenPlant')
            ->markdown('emails.contact-message', [
                'messageModel' => $this->messageModel,
            ]);
    }
}

