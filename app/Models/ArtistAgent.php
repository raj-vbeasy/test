<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArtistAgent
 *
 * @property int $id
 * @property int $artist_id
 * @property string $name
 * @property string|null $email
 * @property string|null $office_number
 * @property string|null $phone
 * @property int $status 0 => inactive, 1 => Active, 3 => Move
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent whereOfficeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistAgent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArtistAgent extends Model
{
    //
}
