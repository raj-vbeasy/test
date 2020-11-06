<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property int $stage_id
 * @property string|null $promoter
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Stage $stages
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event wherePromoter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $performance_location_id
 * @property string|null $status
 * @property string|null $hold_position
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventActivity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $artists
 * @property-read int|null $artists_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventContact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventExpense[] $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventNote[] $notes
 * @property-read int|null $notes_count
 * @property-read \App\Models\PerformanceLocation $performanceLocation
 * @property-read int|null $stages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventTask[] $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event wherePerformanceLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStatus($value)
 */
class Event extends Model
{
    protected $fillable = [
        'name', 'email', 'performance_location_id', 'promoter', 'date', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'notes',
    ];

    const ARTIST_STATUS = [
        '--',
        'Inquiry',
        'Available',
        'Mutually Agreed Date',
        'Not Available',
        'Challenged By',
        'Hold Released by Artist',
        'Offer Collaboration',
        'Confirmed',
        'Declined',
        'Hold Rescinded by Venue',
        'Request to Withdraw Offer',
    ];

    const HOLD_POSITION = [
        '--',
        'Offer Tendered',
        '1st Hold (1H)',
        '2nd Hold (2H)',
        '3rd Hold (3H)',
        '4th Hold (4H)',
        '5th Hold (5H)',
        'Archived Section',
        'Future Consideration',
    ];

    final public function performanceLocation(): BelongsTo
    {
        return $this->belongsTo(PerformanceLocation::class);
    }

    final public function stages(): BelongsToMany
    {
        return $this->belongsToMany(Stage::class);
    }

    final public function notes(): HasMany
    {
        return $this->hasMany(EventNote::class);
    }

    final public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class)->withPivot(['type', 'email', 'updated_at', 'promoter_profit', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'amount', 'notes']);
    }

    final public function artists_headliners(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class)
            ->where('type', '=','headliner')
            ->whereNotIn('status',[3,5,8,11,12,13])
            ->withPivot(['type', 'email', 'promoter_profit', 'updated_at', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'amount', 'notes']);
    }

    final public function artists_support(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class)
            ->where('type', '=','support')
            ->whereNotIn('status',[3,5,8,11,12,13])
            ->withPivot(['type', 'email', 'promoter_profit', 'updated_at', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'amount', 'notes']);
    }

    final public function artists_historical(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class)
            ->whereIn('status',[3,5,8,11,12,13])
            ->withPivot(['type', 'email', 'promoter_profit', 'updated_at', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'amount', 'notes']);
    }

    final public function contacts(): HasMany
    {
        return $this->hasMany(EventContact::class);
    }

    final public function tasks(): HasMany
    {
        return $this->hasMany(EventTask::class);
    }

    final public function activities(): HasMany
    {
        return $this->hasMany(EventActivity::class);
    }

    final public function expenses(): HasMany
    {
        return $this->hasMany(EventExpense::class);
    }
}
