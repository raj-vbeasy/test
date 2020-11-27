<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Artist
 *
 * @property int $id
 * @property $band_name
 * @property $artist_name
 * @property |null $phone
 * @property |null $office_number
 * @property |null $email
 * @property $status 0 => Inactive, 1 => Active
 * @property |null $facebook
 * @property |null $youtube
 * @property |null $instagram
 * @property |null $twitter
 * @property |null $tik_tok
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist newModelQuery, )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist newQuery, )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist query, )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereArtistName, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereBandName, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereCreatedAt, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereEmail, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereFacebook, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereId, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereInstagram, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereOfficeNumber, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist wherePhone, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereStatus, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereTikTok, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereTwitter, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereUpdatedAt, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereYoutube, $value)
 * @mixin \Eloquent
 * @property int $chartmetric_artist_id
 * @property string $name
 * @property string|null $code2
 * @property string $gender
 * @property int $cm_artist_rank
 * @property string|null $cover_url
 * @property string|null $image_url
 * @property string|null $hometown_city
 * @property string|null $current_city
 * @property string|null $record_label
 * @property string|null $band_members
 * @property string|null $press_contact
 * @property string|null $booking_agent
 * @property string|null $description
 * @property mixed|null $tags
 * @property mixed|null $cm_statistics
 * @property int $spotify_popularity
 * @property int $spotify_followers
 * @property int $spotify_monthly_listeners
 * @property int $spotify_listeners_to_followers_ratio
 * @property int $facebook_likes
 * @property int $facebook_talks
 * @property int $youtube_channel_views
 * @property int $youtube_subscribers
 * @property int $wikipedia_views
 * @property int $soundcloud_followers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereBandMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereBookingAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereChartmetricArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereCmArtistRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereCmStatistics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereCode2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereCoverUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereCurrentCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereFacebookLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereFacebookTalks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereHometownCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist wherePressContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereRecordLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereSoundcloudFollowers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereSpotifyFollowers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereSpotifyListenersToFollowersRatio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereSpotifyMonthlyListeners($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereSpotifyPopularity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereWikipediaViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereYoutubeChannelViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artist whereYoutubeSubscribers($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 */
class Artist extends Model
{
    protected $fillable = [
        'chartmetric_artist_id', 'name', 'code2', 'gender', 'cm_artist_rank', 'cover_url', 'image_url',
        'hometown_city', 'current_city', 'record_label', 'band_members', 'press_contact', 'booking_agent', 'description',
        'tags', 'cm_statistics', 'spotify_popularity', 'spotify_followers', 'spotify_monthly_listeners',
        'spotify_listeners_to_followers_ratio', 'facebook_likes', 'facebook_talks', 'youtube_channel_views',
        'youtube_subscribers', 'wikipedia_views', 'soundcloud_followers'
    ];
    
    /**
     * Set the cm statistics for artist.
     *
     * @return void
     */
    final public function setCmStatisticsAttribute($value): void
    {
        if ($value) {
            $this->attributes['cm_statistics'] = json_encode($value);
        }
    }
    
    /**
     * Set the tags for artist.
     *
     * @return void
     */
    final public function setTagsAttribute($value): void
    {
        if ($value) {
            $this->attributes['tags'] = json_encode($value);
        }
    }
    
    final public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)
            ->withPivot(['type', 'email', 'updated_at', 'promoter_profit', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'amount', 'notes', 'offer_expiration_date', 'agency_id', 'management_firm_id', 'publicity_firm_id']);
    }
}
