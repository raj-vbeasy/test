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

            $challengedBy = null;
            $challenged = [];
            if ($status === 'Challenged By') {
                $challengedBy = DB::table('artists')
                    ->where('id', '=', $artist->pivot->challenged_by)
                    ->first('name');

                $hoursTemp = $artist->pivot->challenged_hours > 0 ? $artist->pivot->challenged_hours : 0;
                $challenged = [
                    'by' => $challengedBy ? $challengedBy->name : '',
                    'hours' => $artist->pivot->challenged_hours,
                    'updated_from' => $artist->pivot->updated_at,
                    'updated_to' => (new DateTime($artist->pivot->updated_at))->modify("+ {$hoursTemp} hour")
                ];
            }

            if (in_array($artist->pivot->status, [0,3,4,6,9,10,11])) {
                $artistType = 'historical';
            } else {
                $artistType = strtolower($artist->pivot->type);
            }

            array_push($artists, [
                'id' => $artist->id,
                'name' => $artist->name,
                'image' => $artist->image_url,
                'type' => $artist->pivot->type,
                'category' => $artistType,
                'promoter_profit' => $artist->pivot->promoter_profit,
                'status' => $status,
                'status_color' => EventModel::STATUS_COLOR[$status],
                'hold_position' => $holdPosition,
                'hold_position_order' => $artist->pivot->hold_position,
                'hold_position_color' => EventModel::HOLD_POSITION_COLOR[$holdPosition],
                'amount' => $artist->pivot->amount,
                'notes' => $artist->pivot->notes,
                'date_notes' => $artist->pivot->date_notes,
                'challenged' => $challenged,
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
                'publicity_firm' => ($publicityFirm = PublicityFirm::find($artist->pivot->publicity_firm_id)) ? $publicityFirm->toArray() : [
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
                    'sound_cloud'=> ""
                ],
                'artist_representative_mad' => ($mad = $artist->pivot->artist_representative_mad) ? json_decode($mad) : ['dates' => [], 'notes' => '']
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
            'expenses' => $this->resource->expenses
        ];
    }
}
