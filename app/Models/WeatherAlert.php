<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * WeatherAlert
 *
 * @property string $channel
 * @property string $identifier
 * @property string $location
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
 * @property string|null $executed_at
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
        'channel_type',
        'channel_identifier',
        'precipitation',
        'uv',
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
}
