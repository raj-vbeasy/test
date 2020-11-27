<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PublicityFirm
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $publicist_name
 * @property string|null $publicist_phone
 * @property string|null $publicist_email
 * @property string|null $publicist_assistant_name
 * @property string|null $publicist_assistant_phone
 * @property string|null $publicist_assistant_email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm query()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm wherePublicistAssistantEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm wherePublicistAssistantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm wherePublicistAssistantPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm wherePublicistEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm wherePublicistName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm wherePublicistPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PublicityFirm extends Model
{
    protected $fillable = [
        'name',
        'publicist_name',
        'publicist_phone',
        'publicist_email',
        'publicist_assistant_name',
        'publicist_assistant_phone',
        'publicist_assistant_email'
    ];
}
