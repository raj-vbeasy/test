<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArtistAssistant
 *
 * @property int $id
 * @property int $artist_id
 * @property string $name
 * @property string|null $email
 * @property string|null $cell
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant whereCell($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAssistant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArtistAssistant extends Model
{
    //
}
