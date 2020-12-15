<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Agency
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string $email
 * @property string|null $agent_assistant_name
 * @property string|null $agent_assistant_phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereAgentAssistantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereAgentAssistantPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $agent_name
 * @property string|null $agent_phone
 * @property string $agent_email
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereAgentEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereAgentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereAgentPhone($value)
 */
class Agency extends Model
{
    protected $fillable = ['name', 'agent_name', 'agent_phone', 'agent_email', 'agent_assistant_name', 'agent_assistant_phone'];
}
