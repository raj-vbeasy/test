<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GigSaladArtist
 *
 * @property int $id
 * @property string|null $Name
 * @property string|null $Location
 * @property string|null $Category
 * @property string|null $Price
 * @property string|null $Distance
 * @property string|null $OverviewContent
 * @property string|null $Website
 * @property string|null $Phone
 * @property mixed|null $Texts
 * @property mixed|null $Categories
 * @property mixed|null $Videos
 * @property mixed|null $Photos
 * @property mixed|null $Audios
 * @property string|null $Link
 * @property string|null $gig_salad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereAudios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereGigSaladId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereOverviewContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist wherePhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereTexts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereVideos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GigSaladArtist whereWebsite($value)
 * @mixin \Eloquent
 */
class GigSaladArtist extends Model
{
    protected $fillable = [
        'Name', 'Location', 'Category', 'Price', 'Distance', 'OverviewContent', 'Website', 'Phone', 'Texts',
        'Categories', 'Videos', 'Photos', 'Audios', 'Link', 'gig_salad_id',
    ];
}
