<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventTask;
use App\Traits\HandleApiRequestAndResponse;
use Carbon\Carbon;
use DB;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class EventTaskController extends Controller
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
            'name' => 'required',
            'event_id' => 'exists:events,id',
            'due_date' => 'required|numeric'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $request->merge(['due_date' => Carbon::createFromTimestampMs($request->get('due_date'))->format('Y-m-d H:i:s')]);
                $task = $event->tasks()->create(array_filter($request->only((new EventTask())->getFillable())));
                $data = $request->get('insert_id') ? ['id' => $task->id] : null;
                $this->setResponseVars("Task added", $data);
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
            'event_id' => 'exists:events,id',
            'id' => 'exists:event_tasks',
            'due_date' => 'numeric'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                if ($request->get('due_date')) {
                    $request->merge(['due_date' => Carbon::createFromTimestampMs($request->get('due_date'))->format('Y-m-d H:i:s')]);
                }
                $event->tasks()->find($id)->update(array_filter($request->only((new EventTask())->getFillable())));
                $this->setResponseVars("Task updated");
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
            'id' => 'exists:event_tasks'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $event->tasks()->find($id)->delete();
                $this->setResponseVars("Task deleted");
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
