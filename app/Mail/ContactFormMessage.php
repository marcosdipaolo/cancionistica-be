<?php

namespace App\Mail;

use App\Dto\ContactFormData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private ContactFormData $data)
    {
    }

    /**
     * @return $this
     */
    public function build(): self
    {
        return $this->markdown('emails.contact-form')
            ->from($this->data->getEmail())
            ->with([
                "name" => $this->data->getName(),
                "email" => $this->data->getEmail(),
                "message" => $this->data->getMesage(),
            ]);
    }
}
