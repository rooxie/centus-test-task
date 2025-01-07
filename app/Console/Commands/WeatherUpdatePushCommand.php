<?php

namespace App\Console\Commands;

use App\Repositories\WeatherAlertRepositoryInterface;
use App\Services\LocationService;
use App\Services\RemoteWeatherService\WeatherReport;
use App\Services\WeatherService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use InvalidArgumentException;

class WeatherUpdatePushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'centus:weather-update:push {--location=Oslo} {--uv=0} {--precipitation=0} {--temperature=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a fake weather update notification.';

    /**
     * Execute the console command.
     */
    public function handle(
        LocationService $locationService,
        WeatherService $weatherAlertService,
        WeatherAlertRepositoryInterface $weatherAlertRepository
    ) {
        $location = $locationService->findByName(
            (string)$this->option('location')
        );

        if (!$location) {
            $this->error('Location not found.');
            return;
        }

        try {
            $weatherReport = new WeatherReport(
                Carbon::now(),
                $location,
                (float)$this->option('temperature'),
                (int)$this->option('precipitation'),
                (int)$this->option('uv')
            );
        } catch (InvalidArgumentException $e) {
            $this->error($e->getMessage());
            return;
        }

        foreach ($weatherAlertRepository->enabled() as $weatherAlert) {
            $weatherAlertService::consumeWeatherReport($weatherAlert, $weatherReport);
        }
    }
}
