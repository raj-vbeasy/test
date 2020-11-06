<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Stage
 *
 * @property int $id
 * @property int $performance_location_id
 * @property string $name
 * @property int $capacity
 * @property string $calendar_color
 * @property int $status 0 => inactive, 1 => active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PerformanceLocation $performanceLocation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereCalendarColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage wherePerformanceLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 */
class Stage extends Model
{
    protected $fillable = [
        'name', 'capacity', 'calendar_color', 'status'
    ];
    
    final public function performanceLocation(): BelongsTo
    {
        return $this->belongsTo(PerformanceLocation::class);
    }
    
    final public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
