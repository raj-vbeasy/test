<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
	class Artist extends \Eloquent {}
}

namespace App\Models{
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
	class ArtistAgent extends \Eloquent {}
}

namespace App\Models{
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
	class ArtistAssistant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property int $stage_id
 * @property string|null $promoter
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Stage $stages
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event wherePromoter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $performance_location_id
 * @property string|null $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventActivity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $artists
 * @property-read int|null $artists_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventContact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventExpense[] $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventNote[] $notes
 * @property-read int|null $notes_count
 * @property-read \App\Models\PerformanceLocation $performanceLocation
 * @property-read int|null $stages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventTask[] $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event wherePerformanceLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStatus($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventActivity
 *
 * @property int $id
 * @property int $event_id
 * @property int|null $artist_id
 * @property string|null $crew
 * @property string|null $start
 * @property string|null $end
 * @property string $description
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereCrew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $stage_id
 * @property-read \App\Models\Artist|null $artist
 * @property-read \App\Models\Stage|null $stage
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventActivity whereStageId($value)
 */
	class EventActivity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventContact
 *
 * @property int $id
 * @property int $event_id
 * @property string $email
 * @property string|null $company
 * @property string|null $position
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $notes
 * @property string|null $event_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereEventNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventContact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class EventContact extends \Eloquent {}
}

namespace App\Models{
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
	class EventExpense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventNote
 *
 * @property int $id
 * @property int $event_id
 * @property string $title
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventNote whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $start
 * @property string $end
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereStart($value)
 */
	class EventNote extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventTask
 *
 * @property int $id
 * @property int $event_id
 * @property string $name
 * @property string|null $description
 * @property string|null $due_date
 * @property string|null $status
 * @property string|null $assignee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereAssignee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventTask whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class EventTask extends \Eloquent {}
}

namespace App\Models{
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
	class GigSaladArtist extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PerformanceLocation
 *
 * @property int $id
 * @property string $name
 * @property float $capacity
 * @property string $location
 * @property float $tax_rate
 * @property float $facility_fee
 * @property int $timezone_id
 * @property string $currency
 * @property string $event_template
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereEventTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereFacilityFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereTimezoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PerformanceLocation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stage[] $stages
 * @property-read int|null $stages_count
 * @property-read \App\Models\Timezone $timezone
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 */
	class PerformanceLocation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stage
 *
 * @property int $id
 * @property int $performance_location_id
 * @property string $name
 * @property int $capacity
 * @property string $calendar_color
 * @property int $status 0 => inactive, 1 => active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PerformanceLocation $performanceLocation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereCalendarColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage wherePerformanceLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 */
	class Stage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Timezone
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PerformanceLocation $performanceLocations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $performance_locations_count
 */
	class Timezone extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

