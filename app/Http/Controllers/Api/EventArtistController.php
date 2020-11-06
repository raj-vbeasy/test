<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Traits\HandleApiRequestAndResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class EventArtistController extends Controller
{
    use HandleApiRequestAndResponse;

    final public function create(): JsonResponse
    {
        $data = ['artist_status' => Event::ARTIST_STATUS, 'artist_hold_position' => Event::HOLD_POSITION];
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
            \DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $event->artists()->syncWithoutDetaching(
                    [
                        $request->get('artist_id') => $request->only(['type', 'email', 'promoter_profit', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'amount', 'notes'])
                    ]
                );
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
            $id=$event->id;
            $events = DB::table('artist_event')
                ->where('id','!=', $id)
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
            \DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $event->artists()->updateExistingPivot(
                    $request->get('id'),
                    $request->only(['type', 'email', 'promoter_profit', 'status', 'date_notes', 'challenged_by', 'challenged_hours', 'hold_position', 'notes'])
                );
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
            $events = DB::table('artist_event')
                ->where('id','!=', $id)
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
}
