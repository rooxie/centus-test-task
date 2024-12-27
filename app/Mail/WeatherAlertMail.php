<?php

namespace App\Mail;

use App\Models\WeatherAlert;
use App\Services\WeatherService\WeatherReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeatherAlertMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected WeatherAlert $weatherAlert,
        protected WeatherReport $weatherReport
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Weather Alert: P [>={$this->weatherAlert->pecepitation}], U [>={$this->weatherAlert->uv}]",
            to: $this->weatherAlert->identifier
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.weatherAlert',
            with: [
                'weatherAlert' => $this->weatherAlert,
                'weatherReport' => $this->weatherReport,
            ]
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
