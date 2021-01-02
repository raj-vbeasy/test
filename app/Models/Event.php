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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $artists_headliners
 * @property-read int|null $artists_headliners_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $artists_historical
 * @property-read int|null $artists_historical_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $artists_support
 * @property-read int|null $artists_support_count
 * @property array $challenge
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereChallenge($value)
 * @property int $challenge_expired
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereChallengeExpired($value)
 */
class Event extends Model
{
    protected $fillable = [
        'name', 'email', 'performance_location_id', 'promoter', 'date', 'status', 'challenge', 'challenge_expired'
    ];

    const ARTIST_STATUS = [
        '--',
        'Inquiry',
        'Available',
        'Mutually Agreed Date',
        'Not Available',
        'Initiating Challenge',
        'Hold Released by Artist',
        'Offer Collaboration',
        'Confirmed',
        'Declined',
        'Hold Rescinded by Venue',
        'Request to Withdraw Offer',
        'Challenged By'
    ];

    const HOLD_POSITION = [
        '--',
        'Offer Tendered',
        '1st Hold (1H)',
        '2nd Hold (2H)',
        '3rd Hold (3H)',
        '4th Hold (4H)',
        '5th Hold (5H)',
        'Future Consideration',
    ];

    const STATUS_COLOR = [
        '--' => ['background' => '#999999', 'color' => '#000000'],
        'Inquiry' => ['background' => '#000000', 'color' => '#ffffff'],
        'Available' => ['background' => '#377369', 'color' => '#ffffff'],
        'Mutually Agreed Date' => ['background' => '#f0a714', 'color' => '#000000'],
        'Not Available' => ['background' => '#ff0000', 'color' => '#ffffff'],
        'Initiating Challenge' => ['background' => '#8e7cc3', 'color' => '#000000'],
        'Hold Released by Artist' => ['background' => '#999999', 'color' => '#000000'],
        'Offer Collaboration' => ['background' => '#78d0a0', 'color' => '#000000'],
        'Confirmed' => ['background' => '#38761d', 'color' => '#ffffff'],
        'Declined' => ['background' => '#ff0000', 'color' => '#ffffff'],
        'Hold Rescinded by Venue' => ['background' => '#999999', 'color' => '#000000'],
        'Request to Withdraw Offer' => ['background' => '#ff0000', 'color' => '#ffffff'],
        'Challenged By' => ['background' => '#8e7cc3', 'color' => '#000000']
    ];

    const HOLD_POSITION_COLOR = [
        '--' => ['background' => '#999999', 'color' => '#000000'],
        'Offer Tendered' => ['background' => '#38761d', 'color' => '#ffffff'],
        '1st Hold (1H)' => ['background' => '#78d0a0', 'color' => '#000000'],
        '2nd Hold (2H)' => ['background' => '#f1c232', 'color' => '#000000'],
        '3rd Hold (3H)' => ['background' => '#1155cc', 'color' => '#ffffff'],
        '4th Hold (4H)' => ['background' => '#8e7cc3', 'color' => '#000000'],
        '5th Hold (5H)' => ['background' => '#377369', 'color' => '#ffffff'],
        'Future Consideration' => ['background' => '#f0a714', 'color' => '#000000'],
    ];

    protected $dates = ['date'];

    protected $casts = [
        'challenge' => 'array'
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
        return $this->belongsToMany(Artist::class)
            ->withPivot([
                'type', 'email', 'updated_at', 'promoter_profit', 'status', 'date_notes', 'challenged_by',
                'challenged_hours', 'hold_position', 'amount', 'notes', 'offer_expiration_date', 'agency_id',
                'management_firm_id', 'publicity_firm_id', 'token', 'artist_representative_mad', 'cancellation_terms'
            ]);
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
