<?php

namespace App\Http\Resources;

use App\Models\Agency;
use App\Models\Artist;
use App\Models\ManagementFirm;
use App\Models\PublicityFirm;
use App\Models\Stage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use DB;
use DateTime;
use App\Models\Event AS EventModel;
use Illuminate\Support\Arr;

class Event extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function toArray($request)
    {
        $artists = [];

        foreach ($this->resource->artists as $artist) {
            $status = EventModel::ARTIST_STATUS[$artist->pivot->status];
            $holdPosition = EventModel::HOLD_POSITION[$artist->pivot->hold_position];

            array_push($artists, [
                'id' => $artist->id,
                'name' => $artist->name,
                'image' => $artist->image_url,
                'type' => $artist->pivot->type,
                'promoter_profit' => $artist->pivot->promoter_profit,
                'status' => $status,
                'status_color' => EventModel::STATUS_COLOR[$status],
                'hold_position' => $holdPosition,
                'hold_position_order' => $artist->pivot->hold_position,
                'hold_position_color' => EventModel::HOLD_POSITION_COLOR[$holdPosition],
                'amount' => $artist->pivot->amount,
                'notes' => $artist->pivot->notes,
                'date_notes' => $artist->pivot->date_notes,
                'agency' => ($agency = Agency::find($artist->pivot->agency_id)) ? $agency->toArray() : [
                    "agent_assistant_name" => "",
                    "agent_assistant_phone" => "",
                    "agent_email" => "",
                    "name" => "",
                    "agent_phone" => "",
                    "agent_name" => ""
                ],
                'management_firm' => ($managementFirm = ManagementFirm::find($artist->pivot->management_firm_id)) ? $managementFirm->toArray() : [
                    "manager_assistant_email"=> "",
                    "manager_assistant_name"=> "",
                    "manager_assistant_phone"=> "",
                    "manager_email"=> "",
                    "manager_name"=> "",
                    "manager_phone"=> "",
                    "name"=> ""
                ],
                'publicity_firm' => ($publicityFirm = PublicityFirm::find($artist->pivot->publicity_firm_id)) ? array_merge($publicityFirm->toArray(), ['sound_cloud' => $artist->description]) : [
                    "name"=> "",
                    "publicist_assistant_email"=> "",
                    "publicist_assistant_name"=> "",
                    "publicist_assistant_phone"=> "",
                    "publicist_email"=> "",
                    "publicist_name"=> "",
                    "publicist_phone"=> "",
                    'facebook'=> "",
                    'twitter'=> "",
                    'instagram'=> "",
                    'website'=> "",
                    'apple_music'=> "",
                    'spotify'=> "",
                    'sound_cloud'=> $artist->description
                ],
                'artist_representative_mad' => ($mad = $artist->pivot->artist_representative_mad) ? json_decode($mad) : ['dates' => [], 'notes' => ''],
                'offer_expiration_date' => $artist->pivot->status === 7 ? $artist->pivot->offer_expiration_date : null
            ]);
        }

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
            'contacts' => $this->resource->contacts,
            'tasks' => $this->resource->tasks,
            'activities' => $activities,
            'expenses' => $this->resource->expenses,
            'challenge' => $this->resource->challenge
        ];
    }
}
