<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventNote;
use App\Traits\HandleApiRequestAndResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventNoteController extends Controller
{
    use HandleApiRequestAndResponse;

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
            'title' => 'required',
            'start' => 'required',
            'end' => 'required',
            'text' => 'required',
            'event_id' => 'exists:events,id'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            \DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $request->merge(['start' => Carbon::createFromDate($request->get('start'))->format('Y-m-d')]);
                $request->merge(['end' => Carbon::createFromDate($request->get('end'))->format('Y-m-d')]);
                $note = $event->notes()->create(array_filter($request->only((new EventNote())->getFillable())));
                $data = $request->get('insert_id') ? ['id' => $note->id] : null;
                $this->setResponseVars("Note added", $data);
                \DB::commit();
            } catch (\Exception $exception) {
                \DB::rollBack();
                $this->setResponseVars(
                    'Something went wrong, please try again'.$exception,
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
        $request->merge(['event_id' => $eventId, 'id' => $id]);
        $this->validationRules = [
            'title' => 'required',
            'start' => 'required',
            'end' => 'required',
            'text' => 'required',
            'event_id' => 'exists:events,id',
            'id' => 'exists:event_notes'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            \DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $request->merge(['start' => Carbon::createFromDate($request->get('start'))->format('Y-m-d')]);
                $request->merge(['end' => Carbon::createFromDate($request->get('end'))->format('Y-m-d')]);
                $event->notes()->find($id)->update(array_filter($request->only((new EventNote())->getFillable())));
                $this->setResponseVars("Note updated");
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
            'id' => 'exists:event_notes'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            \DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $event->notes()->find($id)->delete();
                $this->setResponseVars("Note deleted");
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
