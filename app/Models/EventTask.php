<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EventTask
 *
 * @property int $id
 * @property int $event_id
 * @property string $name
 * @property string|null $description
 * @property string|null $due_date
 * @property string|null $status
 * @property string|null $assignee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereAssignee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventTask extends Model
{
    protected $fillable = [
        'name', 'description', 'due_date', 'status', 'assignee'
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
}
