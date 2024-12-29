<?php

namespace App\Notifications;

use App\Models\WeatherAlert;
use App\Services\WeatherService\WeatherReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class WeatherConditionsMatched extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param WeatherAlert $weatherAlert
     * @param WeatherReport $weatherReport
     */
    public function __construct(
        protected WeatherAlert $weatherAlert,
        protected WeatherReport $weatherReport
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if ($this->weatherAlert->channel_type === 'webpush') {
            return [WebPushChannel::class];
        }

        return [MailChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Weather Alert')
            ->markdown('emails.weather-alert', [
                'weatherAlert' => $this->weatherAlert,
                'weatherReport' => $this->weatherReport,
            ]);
    }

    /**
     * @param $notifiable
     * @param $notification
     * @return WebPushMessage
     */
    public function toWebPush($notifiable, $notification)
    {
        $title = "Weather Alert in {$this->weatherAlert->location->name}";
        $message = sprintf(
            'Precipitation: %d, UV: %d',
            $this->weatherAlert->precipitation,
            $this->weatherAlert->uv
        );

        return (new WebPushMessage)
            ->title($title)
            ->body($message);
    }
}
