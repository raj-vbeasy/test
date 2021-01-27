<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\EventActivity
 *
 * @property int $id
 * @property int $event_id
 * @property int|null $artist_id
 * @property string|null $crew
 * @property string|null $start
 * @property string|null $end
 * @property string $description
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereCrew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $stage_id
 * @property-read \App\Models\Artist|null $artist
 * @property-read \App\Models\Stage|null $stage
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereStageId($value)
 * @property string $cell_phone
 * @property string $radio_channel
 * @property string $email
 * @method static \Illuminate\Database\Eloquent\Builder|EventActivity whereCellPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventActivity whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventActivity whereRadioChannel($value)
 */
class EventActivity extends Model
{
    protected $fillable = [
        'artist_id', 'crew', 'stage_id', 'cell_phone', 'radio_channel', 'email', 'start', 'end', 'description', 'type',
        'status', 'offer_expiration_date', 'hold_position'
    ];

    final public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    final public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    /**
     * Set the start date.
     *
     * @param int $value
     * @return void
     */
    final public function setStartAttribute(int $value): void
    {
        if ($value) {
            $this->attributes['start'] = Carbon::createFromTimestampMs($value)->format('Y-m-d H:i:s');
        }
    }

    /**
     * Set the end date.
     *
     * @param int $value
     * @return void
     */
    final public function setEndAttribute(int $value): void
    {
        if ($value) {
            $this->attributes['end'] = Carbon::createFromTimestampMs($value)->format('Y-m-d H:i:s');
        }
    }
}
