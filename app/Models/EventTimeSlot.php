<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTimeSlot extends Model
{
    protected $fillable = ['start', 'end'];

    protected $hidden = ['created_at', 'updated_at'];
}
