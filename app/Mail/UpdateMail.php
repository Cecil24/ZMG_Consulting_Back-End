<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class UpdateMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var User
     */
    public User $user;

    /**
     * @var string
     */
    public string $body;

    /**
     * @var string
     */
    public string $emailSubject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $body, string $subject)
    {
        $this->user = $user;
        $this->body = $body;
        $this->emailSubject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->emailSubject)->markdown('emails.update.update-email');
    }
}
