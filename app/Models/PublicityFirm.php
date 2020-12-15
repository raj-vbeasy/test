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
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $instagram
 * @property string|null $website
 * @property string|null $apple_music
 * @property string|null $spotify
 * @property string|null $sound_cloud
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereAppleMusic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereSoundCloud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereSpotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicityFirm whereWebsite($value)
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
        'publicist_assistant_email',
        'facebook',
        'twitter',
        'instagram',
        'website',
        'apple_music',
        'spotify',
        'sound_cloud'
    ];
}
