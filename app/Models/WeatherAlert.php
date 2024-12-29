<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\PushSubscription;

/**
 * WeatherAlert
 *
 * @property string $channel
 * @property string $identifier
 * @property Location $location
 * @property int $precipitation
 * @property int $uv
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property string $channel_type
 * @property string $channel_identifier
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
 * @mixin \Eloquent
 */
class WeatherAlert extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'location_id',
        'channel_type',
        'precipitation',
        'uv',
        'is_active',
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
     * @return mixed
     */
    public function routeNotificationForWebPush()
    {
        return PushSubscription::findByUserID($this->user_id);
    }

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

    public function getFirstSetAlertValue(): int
    {
        return $this->precipitation ?: $this->uv;
    }
}
