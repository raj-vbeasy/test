<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ManagementFirm
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $manager_name
 * @property string|null $manager_phone
 * @property string|null $manager_email
 * @property string|null $manager_assistant_name
 * @property string|null $manager_assistant_phone
 * @property string|null $manager_assistant_email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm query()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereManagerAssistantEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereManagerAssistantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereManagerAssistantPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereManagerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereManagerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereManagerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementFirm whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ManagementFirm extends Model
{
    protected $fillable = [
        'name',
        'manager_name',
        'manager_phone',
        'manager_email',
        'manager_assistant_name',
        'manager_assistant_phone',
        'manager_assistant_email'
    ];
}
