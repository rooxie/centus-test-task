<?php

namespace App\Console\Commands;

use App\Jobs\ProcessWeatherAlert;
use App\Mail\WeatherAlertMail;
use App\Models\WeatherAlert;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
    public function handle()
    {
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
