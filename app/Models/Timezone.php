<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Timezone
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PerformanceLocation $performanceLocations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $performance_locations_count
 */
class Timezone extends Model
{
    protected $fillable = ['name'];
    
    protected $hidden = ['created_at', 'updated_at'];
    
    /**
     * @return HasMany
     */
    final public function performanceLocations(): HasMany
    {
        return $this->hasMany(PerformanceLocation::class);
    }
}
