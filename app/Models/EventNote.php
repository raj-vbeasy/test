<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EventNote
 *
 * @property int $id
 * @property int $event_id
 * @property string $title
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventNote extends Model
{
    protected $fillable = ['title', 'start', 'end', 'text'];

    protected $hidden = ['event_id', 'created_at', 'updated_at'];
}
