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

        foreach ($this->resource->artists as $artist) {
            $myActivities = [];

            foreach ($activities['stage'] as $activity) {
                if ($activity->artist_id === $artist->id) {
                    $flag = true;
                    foreach ($myActivities as $key => $myActivity) {
                        if ($myActivity['stage']['id'] === $activity->stage->id) {
                            $myActivities[$key]['slots'][] = [
                                'time' => [
                                    'start' => Carbon::createFromFormat('Y-m-d H:i:s', $activity->start)->valueOf(),
                                    'end' => Carbon::createFromFormat('Y-m-d H:i:s', $activity->end)->valueOf()
                                ],
                                'status' => $activity->status,
                                'hold_position' => $activity->hold_position
                            ];
                            $flag = false;
                            break;
                        }
                    }

                    if ($flag === true) {
                        $myActivities[] = [
                            'stage' => $activity->stage->toArray(),
                            'slots' => [
                                [
                                    'time' => [
                                        'start' => Carbon::createFromFormat('Y-m-d H:i:s', $activity->start)->valueOf(),
                                        'end' => Carbon::createFromFormat('Y-m-d H:i:s', $activity->end)->valueOf()
                                    ],
                                    'status' => $activity->status,
                                    'hold_position' => $activity->hold_position
                                ]
                            ]
                        ];
                    }
                }
            }

            array_push($artists, [
                'id' => $artist->id,
                'name' => $artist->name,
                'image' => $artist->image_url,
                'type' => $artist->pivot->type,
                'promoter_profit' => $artist->pivot->promoter_profit,
                'status_color' => EventModel::STATUS_COLOR['--'],
                'hold_position_order' => $artist->pivot->hold_position,
                'hold_position_color' => EventModel::HOLD_POSITION_COLOR['--'],
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
                'offer_expiration_date' => $artist->pivot->status === 7 ? $artist->pivot->offer_expiration_date : null,
                'cancellation_terms' => $artist->pivot->cancellation_terms,
                'my_activities' => $myActivities
            ]);
        }

        $timeSlots = [];
        foreach ($this->resource->timeSlots as $timeSlot) {
            array_push($timeSlots, [
                Carbon::createFromFormat('H:i:s', $timeSlot->start)->valueOf(),
                Carbon::createFromFormat('H:i:s', $timeSlot->end)->valueOf()
            ]);
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
            'challenge' => $this->resource->challenge,
            'time_slots' => $timeSlots
        ];
    }
}
