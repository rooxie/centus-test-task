<?php

namespace App\Jobs;

use App\Mail\WeatherAlertMail;
use App\Models\WeatherAlert;
use App\Services\WeatherService\WeatherServiceAdapterInterface;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class ProcessWeatherAlert implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected WeatherAlert $weatherAlert)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(WeatherServiceAdapterInterface $weatherService): void
    {
        $weatherReport = $weatherService->getWeather($this->weatherAlert->location);

        if (
            $weatherReport->getPerciptation() >= $this->weatherAlert->percipitation
            ||
            $weatherReport->getUv() >= $this->weatherAlert->uv
        ) {
            Mail::send(new WeatherAlertMail(
                weatherAlert: $this->weatherAlert,
                weatherReport: $weatherReport
            ));
        }
    }
}
