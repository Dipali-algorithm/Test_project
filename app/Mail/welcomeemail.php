<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class welcomeemail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailmessage;
    public $subject;
    public $token;
    public $toEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($message , $subject,$token,$toEmail)
    {
        $this->mailmessage = $message;
        $this->subject = $subject;
        $this->token = $token;
        $this->toEmail = $toEmail;
    }
    public function build()
    {
        return $this->view('reset')
                    ->subject($this->subject);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'welcome-mail',
            with: [
                'mailmessage' => $this->mailmessage,
                'subject' => $this->subject,
                'token' => $this->token,
                'toEmail' => $this->toEmail,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
