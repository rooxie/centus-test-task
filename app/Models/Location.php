<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Location
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $capital
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCapital($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereUpdatedAt($value)
 * @property string $country
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCountry($value)
 * @mixin \Eloquent
 */
class Location extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
}
