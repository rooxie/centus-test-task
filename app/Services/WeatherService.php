<?php

namespace App\Services;

use App\Models\WeatherAlert;
use App\Notifications\WeatherConditionsMatched;
use App\Repositories\WeatherAlertRepositoryInterface;
use App\Services\RemoteWeatherService\WeatherReport;
use App\Services\RemoteWeatherService\RemoteWeatherServiceApiAdapterInterface;
use Carbon\Carbon;
use Exception;
use Generator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class WeatherService
{
    /**
     */
    public function __construct(
        protected WeatherAlertRepositoryInterface $weatherAlertRepository,
        protected RemoteWeatherServiceApiAdapterInterface $weatherServiceApiAdapter,
        protected bool $useCache = true,
        protected int $cacheTtl = 30
    ) {
        //
    }

    /**
     * Check if the weather alert matches the weather report and notify the user if it does.
     *
     * @param WeatherAlert $weatherAlert
     * @param WeatherReport $weatherReport
     * @return void
     * @throws Throwable
     */
    public static function consumeWeatherReport(WeatherAlert $weatherAlert, WeatherReport $weatherReport): void
    {
        if ($weatherAlert->enabled && $weatherAlert->matchesWeatherReport($weatherReport)) {
            if ($user = $weatherAlert->user) {
                DB::transaction(function () use ($weatherAlert, $weatherReport, $user) {
                    $weatherAlert->markAsExecuted();
                    $user->notify(
                        new WeatherConditionsMatched($weatherAlert, $weatherReport)
                    );
                });
            }
        }
    }

    /**
     * @param Carbon $date
     * @return Generator
     */
    public function processWeatherAlerts(Carbon $date): Generator
    {
        $weatherAlerts = $this->weatherAlertRepository->enabled();

        yield sprintf(
            'Processing %d weather alerts',
            count($weatherAlerts)
        );

        foreach ($weatherAlerts as $weatherAlert) {
            $key = md5(json_encode([
                'location' => $weatherAlert->location->id,
                'date' => $date->toDateTimeString(),
            ]));

            if ($this->useCache) {
                $weatherReport = Cache::get($key);
            }

            try {
                if (!$weatherReport) {
                    $weatherReport = $this->weatherServiceApiAdapter->getWeather(
                        $weatherAlert->location,
                        $date
                    );

                    if ($this->useCache) {
                        Cache::put($key, $weatherReport, now()->addSeconds($this->cacheTtl));
                    }

                    yield sprintf(
                        '[%s] [Temperature %d] [Precipitation %d] [UV %d]',
                        $weatherAlert->location->name,
                        $weatherReport->getTemperature(),
                        $weatherReport->getPrecipitation(),
                        $weatherReport->getUv()
                    );
                }
            } catch (Throwable $e) {
                yield new Exception(sprintf(
                    'Weather alert [%d] with location [%d] failed: "%s"',
                    $weatherAlert->id,
                    $weatherAlert->location->id,
                    $e->getMessage()
                ));
            }

            if ($weatherAlert && $weatherReport) {
                self::consumeWeatherReport($weatherAlert, $weatherReport);
            }
        }

        yield 'Finished';
    }
}
