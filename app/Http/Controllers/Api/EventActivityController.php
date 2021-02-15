<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventActivity;
use App\Traits\HandleApiRequestAndResponse;
use Carbon\Carbon;
use DB;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class EventActivityController extends Controller
{
    use HandleApiRequestAndResponse;

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param int $eventId
     * @return JsonResponse
     * @throws Throwable
     */
    final public function store(Request $request, int $eventId): JsonResponse
    {
        $request->merge(['event_id' => $eventId]);
        $this->validationRules = [
            'type' => 'required|in:stage,other,crew,important',
            'artist_id' => 'required_if:type,stage',
            'stage_id' => 'required_if:type,stage',
            'crew' => 'required_if:type,crew',
            'cell_phone' => 'required_if:type,crew',
            'radio_channel' => 'required_if:type,crew',
            'email' => 'required_if:type,crew',
            'start' => 'required_if:type,stage,crew,other|nullable|numeric',
            'end' => 'required_with:start|nullable|numeric|gt:start',
            'event_id' => 'exists:events,id',
            'description' => 'required'
        ];
        $this->validationMessages = [
            'end.gt' => 'End time should be later then start time'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            $start = $request->input('start');
            $end = $request->input('end');
            $stage_id = $request->input('stage_id');
            $events = DB::table('event_activities')
                ->where('event_id', '=', $eventId)
                ->where('stage_id', '=', $stage_id)
                ->where(function($q) use ($start) {
                    $q->whereTime('start', '>=', $start)
                        ->orWhereTime('end', '<', $start);
                })
                ->where(function($q) use ($end) {
                    $q->whereTime('start', '<', $end)
                        ->orWhereTime('end', '>=', $end);
                })
                ->get()->count();
            if($events>0) {
                $this->setResponseVars(
                    'Time Slot is already reserved, please try again',
                    null,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
                return $this->apiResponse();
            }
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $activity = $event->activities()->create(array_filter($request->only((new EventActivity())->getFillable())));
                $data = $request->get('insert_id') ? ['id' => $activity->id] : null;
                $this->setResponseVars("Activity added", $data);
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
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
     * @throws Throwable
     */
    final public function update(Request $request, int $eventId, int $id): JsonResponse
    {
        $request->merge(['event_id' => $eventId, 'id' => $id]);
        $this->validationRules = [
            'type' => 'required|in:stage,other,crew,important',
            'artist_id' => 'required_if:type,stage',
            'stage_id' => 'required_if:type,stage',
            'crew' => 'required_if:type,crew',
            'cell_phone' => 'required_if:type,crew',
            'radio_channel' => 'required_if:type,crew',
            'email' => 'required_if:type,crew',
            'start' => 'required_if:type,stage,crew,other|nullable|numeric',
            'end' => 'required_with:start|nullable|numeric|gt:start',
            'event_id' => 'exists:events,id',
            'id' => 'exists:event_activities',
            'description' => 'required'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            $id = $request->input('id');
            $start = $request->input('start');
            $end = $request->input('end');
            $stage_id = $request->input('stage_id');
            $events = DB::table('event_activities')
                ->where('id', '!=', $id)
                ->where('event_id', '=', $eventId)
                ->where('stage_id', '=', $stage_id)
                ->where(function($q) use ($start) {
                    $q->whereTime('start', '>=', $start)
                        ->orWhereTime('end', '<', $start);
                })
                ->where(function($q) use ($end) {
                    $q->whereTime('start', '<', $end)
                        ->orWhereTime('end', '>=', $end);
                })
                ->get()->count();
            if($events>0) {
                $this->setResponseVars(
                    'Time Slot is already reserved, please try again',
                    null,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
                return $this->apiResponse();
                exit;
            }
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $activity = $event->activities()->find($id)->update(array_filter($request->only((new EventActivity())->getFillable())));
                $this->setResponseVars("Activity updated");
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
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
     * @throws Throwable
     */
    final public function destroy(int $eventId, int $id): JsonResponse
    {
        request()->merge(['event_id' => $eventId, 'id' => $id]);
        $this->validationRules = [
            'event_id' => 'exists:events,id',
            'id' => 'exists:event_activities'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $event->activities()->find($id)->delete();
                $this->setResponseVars("Activity deleted");
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
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
     * @param Request $request
     * @param int $eventId
     * @return JsonResponse
     */
    final public function index(Request $request, int $eventId): JsonResponse
    {
        $activities = [];

        $eventActivities = Event::find($eventId)->activities()->with(['artist:id,name,image_url', 'stage:id,name']);

        if ($artistId = $request->get('artist_id')) {
            $eventActivities->where('artist_id', $artistId);
        }

        $eventActivities = $eventActivities->get();

        foreach ($eventActivities as $activity) {
            if (in_array($activity->type, ['other', 'important'])) {
                $activity->date = Carbon::createFromFormat('Y-m-d H:i:s', $activity->updated_at)->format('M d, Y');
            }
            $activities[$activity->type][] = $activity;
        }
        $this->setResponseVars('List of activities', $activities);
        return $this->apiResponse();
    }
}
