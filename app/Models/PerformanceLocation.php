<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\PerformanceLocation
 *
 * @property int $id
 * @property string $name
 * @property float $capacity
 * @property string $location
 * @property float $tax_rate
 * @property float $facility_fee
 * @property int $timezone_id
 * @property string $currency
 * @property string $event_template
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereEventTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereFacilityFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereTimezoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stage[] $stages
 * @property-read int|null $stages_count
 * @property-read \App\Models\Timezone $timezone
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 */
class PerformanceLocation extends Model
{
    protected $fillable = [
        'name', 'capacity', 'location', 'tax_rate', 'facility_fee', 'timezone_id', 'currency', 'event_template'
    ];
    
    final public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class);
    }
    
    final public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
    
    final public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
