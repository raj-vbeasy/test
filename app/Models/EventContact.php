<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EventContact
 *
 * @property int $id
 * @property int $event_id
 * @property string $email
 * @property string|null $company
 * @property string|null $position
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $notes
 * @property string|null $event_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereEventNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventContact extends Model
{
    protected $fillable = [
        'email', 'company', 'position', 'name', 'phone', 'notes', 'event_notes'
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
}
