<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventExpense;
use App\Models\EventTask;
use App\Traits\HandleApiRequestAndResponse;
use Carbon\Carbon;
use DB;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class EventExpenseController extends Controller
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
            'crew' => 'required',
            'event_id' => 'exists:events,id',
            'datetime' => 'required|numeric',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'required'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $request->merge(['datetime' => Carbon::createFromTimestampMs($request->get('datetime'))->format('Y-m-d H:i:s')]);
                $task = $event->expenses()->create(array_filter($request->only((new EventExpense())->getFillable())));
                $data = $request->get('insert_id') ? ['id' => $task->id] : null;
                $this->setResponseVars("Expense added", $data);
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
            'id' => 'exists:event_expenses',
            'datetime' => 'numeric',
            'amount' => 'regex:/^\d+(\.\d{1,2})?$/'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                if ($request->get('datetime')) {
                    $request->merge(['datetime' => Carbon::createFromTimestampMs($request->get('datetime'))->format('Y-m-d H:i:s')]);
                }
                $event->expenses()->find($id)->update(array_filter($request->only((new EventExpense())->getFillable())));
                $this->setResponseVars("Expense updated");
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
            'id' => 'exists:event_expenses'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            DB::beginTransaction();
            try {
                $event = Event::find($eventId);
                $event->expenses()->find($id)->delete();
                $this->setResponseVars("Expense deleted");
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
