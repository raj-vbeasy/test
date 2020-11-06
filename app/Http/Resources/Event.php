<?php

namespace App\Http\Resources;

use App\Models\Artist;
use App\Models\Stage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use DB;
use DateTime;

class Event extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $artists = [];
        $artists_headliners = [];
        $artists_support = [];
        $artists_historical = [];

        $statusColor = [
            '--' => ['background' => '#99999', 'color' => '#000000'],
            'Inquiry' => ['background' => '#000000', 'color' => '#ffffff'],
            'Available' => ['background' => '#377369', 'color' => '#ffffff'],
            'Mutually Agreed Date' => ['background' => '#f0a714', 'color' => '#000000'],
            'Not Available' => ['background' => '#ff0000', 'color' => '#ffffff'],
            'Challenged By' => ['background' => '#8e7cc3', 'color' => '#000000'],
            'Hold Released by Artist' => ['background' => '#999999', 'color' => '#000000'],
            'Offer Collaboration' => ['background' => '#78d0a', 'color' => '#000000'],
            'Confirmed' => ['background' => '#38761d', 'color' => '#ffffff'],
            'Declined' => ['background' => '#ff0000', 'color' => '#ffffff'],
            'Hold Rescinded by Venue' => ['background' => '#999999', 'color' => '#000000'],
            'Request to Withdraw Offer' => ['background' => '#ff0000', 'color' => '#ffffff'],
        ];

        $holdPositionColor = [
            '--' => ['background' => '#999999', 'color' => '#000000'],
            'Offer Tendered' => ['background' => '#38761d', 'color' => '#ffffff'],
            '1st Hold (1H)' => ['background' => '#78d0a', 'color' => '#000000'],
            '2nd Hold (2H)' => ['background' => '#f1c232', 'color' => '#000000'],
            '3rd Hold (3H)' => ['background' => '#1155cc', 'color' => '#ffffff'],
            '4th Hold (4H)' => ['background' => '#8e7cc3', 'color' => '#000000'],
            '5th Hold (5H)' => ['background' => '#377369', 'color' => '#ffffff'],
            'Archived Section' => ['background' => '#999999', 'color' => '#000000'],
            'Future Consideration' => ['background' => '#f0a714', 'color' => '#000000'],
        ];

        foreach ($this->resource->artists as $artist) {
            $artistStatus = \App\Models\Event::ARTIST_STATUS[$artist->pivot->status];
            $artistHoldPosition = \App\Models\Event::HOLD_POSITION[$artist->pivot->hold_position];
            $artistStages = DB::table('event_activities as e')
                ->leftjoin('stages as s','s.id', '=', 'e.stage_id')
                ->where('e.artist_id', '=', $artist->id)
                ->whereNotNull('s.name')
                ->get(['e.start','e.end','e.event_id','s.name','s.id']);
            $artistName = DB::table('artists')
                ->where('id', '=', $artist->pivot->challenged_by)
                ->get('name');
            array_push($artists, [
                'id' => $artist->id,
                'name' => $artist->name,
                'email' => $artist->pivot->email,
                'image' => $artist->image_url,
                'type' => $artist->pivot->type,
                'stages' => $artistStages,
                'promoter_profit' => $artist->pivot->promoter_profit,
                'status' => $artistStatus,
                'status_color' => $statusColor[$artistStatus],
                'hold_position' => $artistHoldPosition,
                'hold_position_order' => $artist->pivot->hold_position,
                'hold_position_color' => $holdPositionColor[$artistHoldPosition],
                'amount' => $artist->pivot->amount,
                'notes' => $artist->pivot->notes,
                'date_notes' => $artist->pivot->date_notes,
                'challenged_by' => $artist->pivot->challenged_by,
                'challenged_by_artist' => $artistName,
                'challenged_hours' => $artist->pivot->challenged_hours,
            ]);
        }

        foreach ($this->resource->artists_headliners as $artist) {
            $artistStatus = \App\Models\Event::ARTIST_STATUS[$artist->pivot->status];
            $artistHoldPosition = \App\Models\Event::HOLD_POSITION[$artist->pivot->hold_position];
            $artistStages = DB::table('event_activities as e')
                ->leftjoin('stages as s','s.id', '=', 'e.stage_id')
                ->where('e.artist_id', '=', $artist->id)
                ->whereNotNull('s.name')
                ->get(['e.start','e.end','e.event_id','s.name','s.id']);
            $artistName = DB::table('artists')
                ->where('id', '=', $artist->pivot->challenged_by)
                ->get('name');
            array_push($artists_headliners, [
                'id' => $artist->id,
                'name' => $artist->name,
                'email' => $artist->pivot->email,
                'image' => $artist->image_url,
                'type' => $artist->pivot->type,
                'stages' => $artistStages,
                'promoter_profit' => $artist->pivot->promoter_profit,
                'status' => $artistStatus,
                'status_color' => $statusColor[$artistStatus],
                'hold_position' => $artistHoldPosition,
                'hold_position_order' => $artist->pivot->hold_position,
                'hold_position_color' => $holdPositionColor[$artistHoldPosition],
                'amount' => $artist->pivot->amount,
                'notes' => $artist->pivot->notes,
                'date_notes' => $artist->pivot->date_notes,
                'challenged_by' => $artist->pivot->challenged_by,
                'challenged_by_artist' => $artistName,
                'challenged_hours' => $artist->pivot->challenged_hours,
            ]);
        }


        foreach ($this->resource->artists_support as $artist) {
            $artistStatus = \App\Models\Event::ARTIST_STATUS[$artist->pivot->status];
            $artistHoldPosition = \App\Models\Event::HOLD_POSITION[$artist->pivot->hold_position];
            $artistStages = DB::table('event_activities as e')
                ->leftjoin('stages as s','s.id', '=', 'e.stage_id')
                ->where('e.artist_id', '=', $artist->id)
                ->whereNotNull('s.name')
                ->get(['e.start','e.end','e.event_id','s.name','s.id']);
            $artistName = DB::table('artists')
                ->where('id', '=', $artist->pivot->challenged_by)
                ->get('name');
            array_push($artists_support, [
                'id' => $artist->id,
                'name' => $artist->name,
                'email' => $artist->pivot->email,
                'image' => $artist->image_url,
                'type' => $artist->pivot->type,
                'stages' => $artistStages,
                'promoter_profit' => $artist->pivot->promoter_profit,
                'status' => $artistStatus,
                'status_color' => $statusColor[$artistStatus],
                'hold_position' => $artistHoldPosition,
                'hold_position_order' => $artist->pivot->hold_position,
                'hold_position_color' => $holdPositionColor[$artistHoldPosition],
                'amount' => $artist->pivot->amount,
                'notes' => $artist->pivot->notes,
                'date_notes' => $artist->pivot->date_notes,
                'challenged_by' => $artist->pivot->challenged_by,
                'challenged_by_artist' => $artistName,
                'challenged_hours' => $artist->pivot->challenged_hours,
            ]);
        }

        foreach ($this->resource->artists_historical as $artist) {
            $artistStatus = \App\Models\Event::ARTIST_STATUS[$artist->pivot->status];
            $artistHoldPosition = \App\Models\Event::HOLD_POSITION[$artist->pivot->hold_position];
            $artistStages = DB::table('event_activities as e')
                ->leftjoin('stages as s','s.id', '=', 'e.stage_id')
                ->where('e.artist_id', '=', $artist->id)
                ->whereNotNull('s.name')
                ->get(['e.start','e.end','e.event_id','s.name','s.id']);
            $artistName = DB::table('artists')
                ->where('id', '=', $artist->pivot->challenged_by)
                ->get('name');
            if($artist->pivot->challenged_hours>0){
                $hours=$artist->pivot->challenged_hours;
            }else{
                $hours=0;
            }
            $artist_updated_to = new DateTime($artist->pivot->updated_at);
            $artist_updated_to->modify('+ '.$hours.' hour');
            array_push($artists_historical, [
                'id' => $artist->id,
                'name' => $artist->name,
                'email' => $artist->pivot->email,
                'image' => $artist->image_url,
                'type' => $artist->pivot->type,
                'stages' => $artistStages,
                'promoter_profit' => $artist->pivot->promoter_profit,
                'status' => $artistStatus,
                'status_color' => $statusColor[$artistStatus],
                'hold_position' => $artistHoldPosition,
                'hold_position_order' => $artist->pivot->hold_position,
                'hold_position_color' => $holdPositionColor[$artistHoldPosition],
                'amount' => $artist->pivot->amount,
                'notes' => $artist->pivot->notes,
                'date_notes' => $artist->pivot->date_notes,
                'challenged_by' => $artist->pivot->challenged_by,
                'challenged_by_artist' => $artistName,
                'challenged_hours' => $artist->pivot->challenged_hours,
                'challenged_by_updated_from' => $artist->pivot->updated_at,
                'challenged_by_updated_to' => $artist_updated_to,
            ]);
        }

        usort($artists, function($a, $b) {return strcmp($a['hold_position_order'], $b['hold_position_order']);});
        usort($artists_headliners, function($a, $b) {return strcmp($a['hold_position_order'], $b['hold_position_order']);});
        usort($artists_support, function($a, $b) {return strcmp($a['hold_position_order'], $b['hold_position_order']);});
        usort($artists_historical, function($a, $b) {return strcmp($a['hold_position_order'], $b['hold_position_order']);});

        $activities = [
            'stage' => [],
            'other' => [],
            'crew' => [],
            'important' => []
        ];

        foreach ($this->resource->activities as $activity) {
            if (in_array($activity->type, ['other', 'important'])) {
                $activity->date = Carbon::createFromFormat('Y-m-d H:i:s', $activity->updated_at)->format('M d, Y');
            }
            $activities[$activity->type][] = $activity;
        }
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'stages' => $this->resource->stages,
            'location' => $this->resource->performanceLocation->name,
            'promoter' => $this->resource->promoter,
            'date' => $this->resource->date,
            'status' => $this->resource->status,
            'notes' => $this->resource->notes,
            'artists' => $artists,
            'artists_headliners' => $artists_headliners,
            'artists_support' => $artists_support,
            'artists_historical' => $artists_historical,
            'contacts' => $this->resource->contacts,
            'tasks' => $this->resource->tasks,
            'activities' => $activities,
            'expenses' => $this->resource->expenses
        ];
    }
}
