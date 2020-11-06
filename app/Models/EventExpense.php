<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EventExpense
 *
 * @property int $id
 * @property int $event_id
 * @property string $crew
 * @property float $amount
 * @property string|null $description
 * @property string|null $datetime
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense whereCrew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventExpense whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventExpense extends Model
{
    protected $fillable = [
        'crew', 'amount', 'description', 'datetime'
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
    
    final public function getDatetimeAttribute(string $value): int
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->getPreciseTimestamp(3);
    }
}
