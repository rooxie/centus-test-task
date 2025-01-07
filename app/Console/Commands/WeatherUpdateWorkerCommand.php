<?php

namespace App\Console\Commands;

use App\Repositories\WeatherAlertRepository;
use App\Services\RemoteWeatherService\FakeOpenMeteoApiAdapterService;
use App\Services\WeatherService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Throwable;

class WeatherUpdateWorkerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'centus:weather-update:worker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Worker command for scheduled weather updates and alerts.';

    /**
     * Execute the console command.
     */
    public function handle(
        WeatherAlertRepository $weatherAlertRepository,
        FakeOpenMeteoApiAdapterService $fakeOpenMeteoApiAdapterServiceApi
    ) {
        $weatherAlertService = new WeatherService(
            $weatherAlertRepository,
            $fakeOpenMeteoApiAdapterServiceApi
        );

        foreach ($weatherAlertService->processWeatherAlerts(Carbon::now()) as $status) {
            if ($status instanceof Throwable) {
                $this->error(
                    sprintf(
                        '[%s] %s (%s) %s',
                        Carbon::now()->toDateTimeString(),
                        $this->signature,
                        $weatherAlertService::class,
                        $status->getMessage()
                    )
                );
            } else {
                $this->info(
                    sprintf(
                        '[%s] %s (%s) %s',
                        Carbon::now()->toDateTimeString(),
                        $this->signature,
                        $weatherAlertService::class,
                        $status
                    )
                );
            }
        }
    }
}
