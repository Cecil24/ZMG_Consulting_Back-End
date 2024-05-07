<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientDocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Client
     */
    public Client $client;

    /**\
     * @var string
     */
    public string $body;

    /**\
     * @var string
     */
    public string $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Client $client, string $body, string $url)
    {
        $this->client = $client;
        $this->body = $body;
        $this->link = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->markdown('emails.client.client-documents-request');
    }
}
