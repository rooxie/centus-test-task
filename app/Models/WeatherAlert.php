<?php

namespace App\Models;

use App\Services\RemoteWeatherService\WeatherReport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;

/**
 * WeatherAlert
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert wherePecepitation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereUv($value)
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereId($value)
 * @property \Illuminate\Support\Carbon|null $executed_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereExecutedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereChannelIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereChannelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert wherePrecipitation($value)
 * @property int $location_id
 * @property int $is_active
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereLocationId($value)
 * @property int $user_id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereUserId($value)
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property string $metric
 * @property int $threshold
 * @property int $enabled
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereMetric($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeatherAlert whereThreshold($value)
 * @property string $channel
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location $location
 * @mixin \Eloquent
 */
class WeatherAlert extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'location_id',
        'channel',
        'metric',
        'threshold',
        'enabled',
        'executed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'executed_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Update last executed time and save the model.
     *
     * @return void
     */
    public function markAsExecuted(): void
    {
        $this->executed_at = now();
        $this->save();
    }

    /**
     * Check if the weather alert matches the weather report.
     *
     * @param WeatherReport $weatherReport
     * @return bool
     */
    public function matchesWeatherReport(WeatherReport $weatherReport): bool
    {
        if ($this->location->id !== $weatherReport->getLocation()->id) {
            return false;
        }

        if ($this->metric === 'precipitation') {
            if ($this->threshold > $weatherReport->getPrecipitation()) {
                return false;
            }
        }

        if ($this->metric === 'uv') {
            if ($this->threshold > $weatherReport->getUv()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isWebpush(): bool
    {
        return $this->channel === 'webpush';
    }
}
