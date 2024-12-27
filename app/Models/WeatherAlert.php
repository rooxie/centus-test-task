<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * WeatherAlert
 *
 * @property string $channel
 * @property string $identifier
 * @property string $location
 * @property int $pecepitation
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
 * @mixin \Eloquent
 */
class WeatherAlert extends Model
{
    //
}
