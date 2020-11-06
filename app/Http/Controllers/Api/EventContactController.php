<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventContact;
use App\Traits\HandleApiRequestAndResponse;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class EventContactController extends Controller
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
            'email' => 'required|email|unique:event_contacts',
            'event_id' => 'exists:events,id'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $contact = $event->contacts()->create(array_filter($request->only((new EventContact())->getFillable())));
                $data = $request->get('insert_id') ? ['id' => $contact->id] : null;
                $this->setResponseVars("Contact added", $data);
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
            'email' => 'required|email|unique:event_contacts,email,' . $id . ',id',
            'event_id' => 'exists:events,id',
            'id' => 'exists:event_contacts'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $event->contacts()->find($id)->update(array_filter($request->only((new EventContact())->getFillable())));
                $this->setResponseVars("Contact updated");
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
            'id' => 'exists:event_contacts'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $event->contacts()->find($id)->delete();
                $this->setResponseVars("Note deleted");
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
}
