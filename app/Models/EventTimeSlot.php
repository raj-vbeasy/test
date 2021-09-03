<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EventTimeSlot
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EventTimeSlot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventTimeSlot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventTimeSlot query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $event_id
 * @property string $start
 * @property string $end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EventTimeSlot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventTimeSlot whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventTimeSlot whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventTimeSlot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventTimeSlot whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventTimeSlot whereUpdatedAt($value)
 */
class EventTimeSlot extends Model
{
    protected $fillable = ['start', 'end'];

    protected $hidden = ['created_at', 'updated_at'];
}
