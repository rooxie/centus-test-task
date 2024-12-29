<?php

namespace App\Console\Commands;

use App\Jobs\ProcessWeatherAlert;
use App\Models\WeatherAlert;
use App\Notifications\WeatherConditionsMatched;
use App\Services\WeatherService\WeatherServiceAdapterInterface;
use Illuminate\Console\Command;

class ProcessWeatherAlertsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'centus:weather-alerts-worker {--interval=1} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process weather alerts.';

    /**
     * Execute the console command.
     */
    public function handle(WeatherServiceAdapterInterface $weatherService)
    {
        $weatherAlert = WeatherAlert::query()->find(3);
        $user = $weatherAlert->user;
        $user->notify(new WeatherConditionsMatched(
            $weatherAlert,
            $weatherService->getWeather($weatherAlert->location)
        ));

        dd('stop');
        $interval = (int)$this->option('interval');

        $this->info("Start processing weather alerts every {$interval} seconds.");

        while ($count = WeatherAlert::query()->count()) {
            $this->line("There are <fg=yellow>{$count}</> weather alerts to process.");

            WeatherAlert::query()->chunk(100, function ($weatherAlerts) {
                $weatherAlerts->each(function (WeatherAlert $weatherAlert) {
                    if (rand(0, 1)) {
                        dispatch(
                            new ProcessWeatherAlert($weatherAlert)
                        );
                        $this->line("[<fg=green>{$weatherAlert->id}</>] Sent to job for further processing.");
                    } else {
                        $this->warn("[<fg=green>{$weatherAlert->id}</>] Skipped the because user paused it until 5pm.");
                    }
                });
            });

            sleep($interval);
        }
    }
}
