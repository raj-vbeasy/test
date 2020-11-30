<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Artist;
use App\Models\Event;
use App\Models\ManagementFirm;
use App\Models\PublicityFirm;
use App\Models\User;
use App\Notifications\ArtistStatusUpdate;
use App\Traits\HandleApiRequestAndResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Activitylog\Traits\LogsActivity;

class EventArtistController extends Controller
{
    use HandleApiRequestAndResponse,
        LogsActivity;

    final public function create(): JsonResponse
    {
        $data = [
            'statuses' => Event::ARTIST_STATUS,
            'status_colors' => Event::STATUS_COLOR,
            'hold_positions' => Event::HOLD_POSITION,
            'hold_positions_colors' => Event::HOLD_POSITION_COLOR
        ];
        $this->setResponseVars('Data for artist form', $data);
        return $this->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param int $eventId
     * @return JsonResponse
     * @throws \Throwable
     */
    final public function store(Request $request, int $eventId): JsonResponse
    {
        $request->merge(['event_id' => $eventId]);
        $this->validationRules = [
            'type' => 'required',
            'event_id' => 'exists:events,id',
            'artist_id' => 'required|exists:artists,id',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'agency.name' => 'required',
            'agency.email' => 'required|email',
            'status' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (empty(Event::ARTIST_STATUS[$value])) {
                        $fail($attribute.' is invalid.');
                    }
                }
            ],
            'hold_position' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (empty(Event::HOLD_POSITION[$value])) {
                        $fail($attribute.' is invalid.');
                    }
                }
            ]
        ];
        $this->validationMessages = [
            'agency.name.required' => 'Agency name is required',
            'agency.email.required' => 'Agency email is required',
            'agency.email.email' => 'Please enter valid agency email'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            $event = Event::find($eventId);
            \DB::beginTransaction();
            try {
                if ($request->get('offer_expiration_date')) {
                    $request->merge(['offer_expiration_date' => Carbon::createFromTimestampMs($request->get('offer_expiration_date'))->format('Y-m-d H:i:s')]);
                }

                $agency = Agency::create($request->get('agency'));
                $managementFirm = ManagementFirm::create($request->get('management_firm'));
                $publicityFirm = PublicityFirm::create($request->get('publicity_firm'));

                $request->merge([
                    'agency_id' => $agency->id,
                    'management_firm_id' => $managementFirm->id,
                    'publicity_firm_id' => $publicityFirm->id,
                    'token' => str_ireplace('-', '',Str::uuid() . Str::random(20))
                ]);

                $event->artists()->syncWithoutDetaching(
                    [
                        $request->get('artist_id') => $request->only(['type', 'promoter_profit', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'amount', 'notes', 'offer_expiration_date', 'agency_id', 'management_firm_id', 'publicity_firm_id', 'token'])
                    ]
                );

                $id=$event->id;
                $events = DB::table('artist_event')
                    ->where('artist_id','!=', $id)
                    ->where('event_id', '=', $eventId)
                    ->where('hold_position', '>=', $request->input('hold_position'))
                    ->orderBy('hold_position')
                    ->get('id');
                foreach ($events as $k=>$e) {
                    $hold_position = $k+$request->input('hold_position');
                    DB::table('artist_event')
                        ->where('id', '=', $e->id)
                        ->update(['hold_position' => $hold_position]);
                }

                // Notify related artists
                $this->sendStatusAlert($event, $request->get('artist_id'), $request->get('status'));

                // Log status activity
                activity()
                    ->inLog('Artist Status')
                    ->on($event)
                    ->withProperties([
                        'old' => '',
                        'new' => Event::ARTIST_STATUS[$request->get('status')],
                        'artist_name' => ($event->artists()->where('artist_id', $request->get('artist_id'))->first())->name
                    ])
                    ->log('Added artist with status "'.Event::ARTIST_STATUS[$request->get('status')].'"');

                $this->setResponseVars("Artist added");
                \DB::commit();
            } catch (\Exception $exception) {
                \DB::rollBack();
                $this->setResponseVars(
                    'Something went wrong, please try again',
                    null,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }
        return $this->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $eventId
     * @param int $id
     * @return JsonResponse
     * @throws \Throwable
     */
    final public function update(Request $request, int $eventId, int $id): JsonResponse
    {
        $request->merge(
            ['event_id' => $eventId, 'id' => $id]
        );
        $this->validationRules = [
            'event_id' => 'exists:events,id',
            'id' => 'exists:artists',
            'agency.name' => 'required',
            'agency.email' => 'required|email',
            'status' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (empty(Event::ARTIST_STATUS[$value])) {
                        $fail($attribute.' is invalid.');
                    }
                }
            ],
            'hold_position' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (empty(Event::HOLD_POSITION[$value])) {
                        $fail($attribute.' is invalid.');
                    }
                }
            ]
        ];
        $this->validateApiRequest();

        if ($this->isInputValid) {
            $event = Event::find($eventId);
            $oldData = $event->artists()->where('artist_id', $request->get('id'))->first();

            \DB::beginTransaction();
            try {
                if ($request->get('offer_expiration_date')) {
                    $request->merge(['offer_expiration_date' => Carbon::createFromTimestampMs($request->get('offer_expiration_date'))->format('Y-m-d H:i:s')]);
                }

                $event->artists()->updateExistingPivot(
                    $request->get('id'),
                    $request->only(['type', 'email', 'promoter_profit', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'notes', 'offer_expiration_date'])
                );

                $agency = Agency::find($oldData->pivot->agency_id);
                if ($agency) {
                    $agency->fill($request->get('agency'));
                    if ($agency->isDirty()) {
                        $agency->save();
                    }
                }

                $managementFirm = ManagementFirm::find($oldData->pivot->management_firm_id);
                if ($managementFirm) {
                    $managementFirm->fill($request->get('management_firm'));
                    if ($managementFirm->isDirty()) {
                        $managementFirm->save();
                    }
                }

                $publicityFirm = PublicityFirm::find($oldData->pivot->publicity_firm_id);
                if ($publicityFirm) {
                    $publicityFirm->fill($request->get('publicity_firm'));
                    if ($publicityFirm->isDirty()) {
                        $publicityFirm->save();
                    }
                }


                $events = DB::table('artist_event')
                    ->where('artist_id','!=', $id)
                    ->where('event_id', '=', $eventId)
                    ->where('hold_position', '>=', $request->input('hold_position'))
                    ->orderBy('hold_position')
                    ->get('id');
                foreach ($events as $k=>$e) {
                    $hold_position = $k+$request->input('hold_position');
                    DB::table('artist_event')
                        ->where('id', '=', $e->id)
                        ->update(['hold_position' => $hold_position]);
                }

                // Notify related artists
                if (($oldData->pivot->status !== $request->get('status')) || ($oldData->pivot->hold_position !== $request->get('hold_position'))) {
                    $this->sendStatusAlert($event, $request->get('id'), $request->get('status'));
                }

                if ($oldData->pivot->status !== $request->get('status')) {
                    // Log status activity
                    activity()
                        ->inLog('Artist Status')
                        ->on($event)
                        ->withProperties([
                            'old' => Event::ARTIST_STATUS[$oldData->pivot->status],
                            'new' => Event::ARTIST_STATUS[$request->get('status')],
                            'artist_name' => $oldData->name
                        ])
                        ->log('Artist status updated');
                }


                $this->setResponseVars("Artist updated");
                \DB::commit();
            } catch (\Exception $exception) {
                \DB::rollBack();
                $this->setResponseVars(
                    'Something went wrong, please try again',
                    null,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }
        return $this->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $eventId
     * @param int $id
     * @return JsonResponse
     * @throws \Throwable
     */
    final public function destroy(int $eventId, int $id): JsonResponse
    {
        request()->merge(['event_id' => $eventId, 'id' => $id]);
        $this->validationRules = [
            'event_id' => 'exists:events,id',
            'id' => 'exists:artists'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            \DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $event->artists()->detach($id);
                $this->setResponseVars("Artist deleted");
                \DB::commit();
            } catch (\Exception $exception) {
                \DB::rollBack();
                $this->setResponseVars(
                    'Something went wrong, please try again',
                    null,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }
        return $this->apiResponse();
    }

    final private function sendStatusAlert(Event $event, $artistId, $status)
    {
        $artistEventData = $event->artists()->where('artist_id', $artistId)->first();

        $agency = Agency::find($artistEventData->pivot->agency_id);

        if ($artistEventData && $agency) {
            $location = $event->performanceLocation;

            $content = [
                'admin' => [
                    'email' => auth()->user()->email,
                    'name' => auth()->user()->name
                ],
                'artist' => [
                    'agent' => $agency->name,
                    'name' => $artistEventData->name,
                    'status' => Event::ARTIST_STATUS[$artistEventData->pivot->status]
                ],
                'event' => [
                    'name' => $event->name,
                    'date' => $event->date->format('m-d-Y')
                ],
                'location' => [
                    'name' => $location->name,
                    'link' => 'https://maps.google.com/?q=indore',
                    'capacity' => $location->capacity
                ],
                'url' => route('mad', ['token' => $artistEventData->pivot->token])
            ];
            switch($artistEventData->pivot->status) {
                case 1:
                    $content['view'] = 'emails.artist_status_update.inquiry';
                    ((new User())->fill([
                        'email' => $agency->email
                    ]))->notify(new ArtistStatusUpdate($content));
                    break;
                case 2:
                    if ($artistEventData->pivot->hold_position == 0) {
                        $content['view'] = 'emails.artist_status_update.available.no_hold';
                    } else {
                        $content['view'] = 'emails.artist_status_update.available.hold';
                    }
                    $content['artist']['hold_position'] = Event::HOLD_POSITION[$artistEventData->pivot->hold_position];
                    ((new User())->fill([
                        'email' => $agency->email
                    ]))->notify(new ArtistStatusUpdate($content));
                    break;
                case 3:
                    if ($artistEventData->pivot->hold_position === 8) {
                        $content['view'] = 'emails.artist_status_update.mutually_agreeable_dates';
                        $content['artist']['hold_position'] = Event::HOLD_POSITION[$artistEventData->pivot->hold_position];

                        ((new User())->fill([
                            'email' => $agency->email
                        ]))->notify(new ArtistStatusUpdate($content));
                    }
                    break;
                case 4:
                    $content['view'] = 'emails.artist_status_update.not_available';

                    ((new User())->fill([
                        'email' => $agency->email
                    ]))->notify(new ArtistStatusUpdate($content));
                    break;
                case 5:
                    $content['view'] = 'emails.artist_status_update.challenged.to';
                    $content['challenge_expiration_hours'] = $artistEventData->pivot->challenged_hours;
                    $content['artist']['hold_position'] = Event::HOLD_POSITION[$artistEventData->pivot->hold_position];

                    ((new User())->fill([
                        'email' => $agency->email
                    ]))->notify(new ArtistStatusUpdate($content));

                    $content['view'] = 'emails.artist_status_update.challenged.by';
                    $challengedBy = Artist::find($artistEventData->pivot->challenged_by);
                    // Send email to artist who challenged first hold
                    $challengedByData = $challengedBy->events()->where('event_id', $event->id)->first();
                    $content['artist']['hold_position'] = Event::HOLD_POSITION[$challengedByData->pivot->hold_position];

                    ((new User())->fill([
                        'email' => $challengedByData->pivot->email
                    ]))->notify(new ArtistStatusUpdate($content));
                    break;
                case 6:
                case 10:
                    $content['view'] = 'emails.artist_status_update.hold_released';
                    $content['artist']['hold_position'] = Event::HOLD_POSITION[$artistEventData->pivot->hold_position];

                    ((new User())->fill([
                        'email' => $agency->email
                    ]))->notify(new ArtistStatusUpdate($content));
                    break;
                case 7:
                    if (in_array($artistEventData->pivot->hold_position, [1, 2])) {
                        $content['view'] = 'emails.artist_status_update.offer_collaboration';
                        $content['offer_expiration_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $artistEventData->pivot->offer_expiration_date)->format('m-d-Y');
                        ((new User())->fill([
                            'email' => $agency->email
                        ]))->notify(new ArtistStatusUpdate($content));
                    }
                    break;
                case 8:
                    $content['view'] = 'emails.artist_status_update.confirmed.artist';

                    ((new User())->fill([
                        'email' => $agency->email
                    ]))->notify(new ArtistStatusUpdate($content));

                    // Inform all other artists about their new hold position
                    foreach ($event->artists as $artist) {
                        if ($artist->id !== $artistId) {
                            $content['view'] = 'emails.artist_status_update.confirmed.released';
                            $content['artist']['agent'] = $artist->name;
                            $content['artist']['name'] = $artist->name;
                            $content['artist']['status'] = Event::ARTIST_STATUS[$artist->pivot->status];
                            $content['artist']['hold_position'] = Event::HOLD_POSITION[$artist->pivot->hold_position];
                            $content['url'] = '';

                            ((new User())->fill([
                                'email' => $artist->pivot->email
                            ]))->notify(new ArtistStatusUpdate($content));
                        }
                    }
                    break;
                case 9:
                    $content['view'] = 'emails.artist_status_update.declined';
                    $content['artist']['hold_position'] = Event::HOLD_POSITION[$artistEventData->pivot->hold_position];

                    ((new User())->fill([
                        'email' => $agency->email
                    ]))->notify(new ArtistStatusUpdate($content));

                    // Inform all other artists about their new hold position
                    //foreach ($event->artists as $artist) {
                    //if ($artist->id !== $artistId) {
                    //((new User())->fill([
                    //'email' => $artist->pivot->email,
                    //'name' => $artist->name
                    //]))->notify(
                    //new ArtistStatusUpdate(
                    //'Your hold position is changed to <b>'.Event::HOLD_POSITION[$artistEventData->pivot->hold_position].'</b>'
                    //)
                    //);
                    //}
                    //}
                    break;
                case 11:
                    if (false) {
                        ((new User())->fill([
                            'email' => $artistEventData->pivot->email,
                            'name' => $artistEventData->name
                        ]))->notify(
                            new ArtistStatusUpdate(
                                'You have requested to withdrawal offer, So, your status has been changed to <b>' . Event::ARTIST_STATUS[$artistEventData->pivot->status] . '</b><br/><br/>'.
                                ' We request you for mutually agreeable dates and for deposit return'
                            )
                        );

                        // Inform all other artists about their new hold position
                        foreach ($event->artists as $artist) {
                            if ($artist->id !== $artistId) {
                                ((new User())->fill([
                                    'email' => $artist->pivot->email,
                                    'name' => $artist->name
                                ]))->notify(
                                    new ArtistStatusUpdate(
                                        'Your hold position is changed to <b>'.Event::HOLD_POSITION[$artistEventData->pivot->hold_position].'</b>'
                                    )
                                );
                            }
                        }
                    }
                    break;
                default:
                    $content = '';
                    break;
            }
        }
    }

    final public function updateRepresentativeMad(Request $request, $token)
    {
        $isDateRequired = strtolower($request->get('yes_no', 'no')) === 'yes';

        $arr = [
            'notes' => $request->get('notes', ''),
            'dates' => []
        ];

        if ($isDateRequired) {
            $flag = true;
            foreach ($request->get('dates', []) as $date) {
                if (!empty($date['month']) && !empty($date['day']) && !empty($date['year'])) {
                    $arr['dates'][] = $date;
                    $flag = false;
                }
            }

            if ($flag) {
                return redirect()->back()->withInput()->withErrors(['date' => 'Select one date at least']);
            }
        }

        DB::table('artist_event')
            ->where('token', $token)
            ->update(['artist_representative_mad' => json_encode($arr)]);

        return redirect()->back()->with(['success' => 'Data submitted successfully']);
    }
}
