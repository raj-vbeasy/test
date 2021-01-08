<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PerformanceLocation;
use App\Traits\HandleApiRequestAndResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;
use App\Http\Resources\Event as EventResource;

class EventController extends Controller
{
    use HandleApiRequestAndResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    final public function index(Request $request): JsonResponse
    {
        $this->validationRules = [
            'start' => 'required|numeric',
            'end' => 'required|numeric|gte:start'
        ];
        $this->validationMessages = [
            'start.required' => 'Start date should be valid timestamp',
            'start.numeric' => 'Start date should be valid timestamp',
            'end.required' => 'Start date should be valid timestamp',
            'end.numeric' => 'End date should be valid timestamp',
            'end.gte' => 'End date should be greater than start date'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            $this->setResponseVars(
                'List of Events',
                Event::with(['performanceLocation', 'stages', 'notes', 'timeSlots'])
                    ->whereBetween(
                        \DB::raw('DATE(date)'),
                        [
                            Carbon::createFromTimestampMs($request->get('start'))->format('Y-m-d'),
                            Carbon::createFromTimestampMs($request->get('end'))->format('Y-m-d')
                        ]
                    )
                    ->paginate()
            );
        }
        
        return $this->apiResponse();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    final public function create(): JsonResponse
    {
        $performanceLocations = PerformanceLocation::with(['stages' => function ($query) {
            $query->where('status', 1);
        }])->get();
        $msg = $performanceLocations->count() > 0 ? 'Performance Locations' : 'No Performance Location';
        $this->setResponseVars($msg, $performanceLocations);
        return $this->apiResponse();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    final public function store(Request $request): JsonResponse
    {
        $this->validationRules = [
            'name' => 'required',
            'email' => 'required|email',
            'performance_location_id' => 'required|exists:performance_locations,id',
            'stages' => 'required|array',
            'time_slots' => 'required|array'
        ];
        $this->validationMessages = [
            'name.required' => 'Please enter event name',
            'email.numeric' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'performance_location_id.required' => 'Please select performance location',
            'performance_location_id.exists' => 'Invalid Performance location',
            'stages.required' => 'Please select at least 1 stage',
            'stages.array' => 'Invalid stages',
            'time_slots.required' => 'Please enter at least 1 time slot'
        ];
        $this->validateApiRequest();
        if ($this->isInputValid) {
            \DB::beginTransaction();
            try {
                $request->merge(
                    [
                        'date' => Carbon::createFromTimestampMs($request->get('date'))
                    ]
                );
                $event = Event::create(array_filter($request->only((new Event())->getFillable())));
                $event->stages()->sync($request->get('stages'));
                $timeSlots = [];
                foreach ($request->get('time_slots', []) as $timeSlot) {
                    $timeSlots[] = [
                        'start' => Carbon::createFromTimestampMs($timeSlot[0])->format('H:i:s'),
                        'end' => Carbon::createFromTimestampMs($timeSlot[1])->format('H:i:s')
                    ];
                }
                if ($timeSlots) {
                    $event->timeSlots()->createMany($timeSlots);
                }
                \DB::commit();
                $this->setResponseVars('Added new Event');
            } catch (\Exception $exception) {
                \DB::rollBack();
                echo '<pre>'; print_r($exception->getMessage());
                $this->setResponseVars('Something went wrong, please try again!');
            }
        }
        return $this->apiResponse();
    }
    
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    final public function show(int $id): JsonResponse
    {
        $event = Event::with([
            'performanceLocation:id,name,capacity,location,tax_rate,facility_fee,timezone_id,currency,event_template',
            'stages:id,name,status',
            'artists:id,name,image_url,description',
            'activities:id,event_id,artist_id,stage_id,crew,start,end,description,type',
            'activities.stage:id,name',
            'activities.artist:id,name,image_url',
            'expenses:id,event_id,crew,amount,description,description,datetime'
        ])
        ->select('id', 'name', 'email', 'performance_location_id', 'promoter', 'date', 'status', 'challenge')
        ->find($id);

        if ($event) {
            $this->setResponseVars('Event Details', new EventResource($event));
        } else {
            $this->setResponseVars('Event not found', null, Response::HTTP_NOT_FOUND);
        }
        return $this->apiResponse();
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Event $event
     * @return JsonResponse
     * @throws Throwable
     */
    final public function update(Request $request, Event $event): JsonResponse
    {
        $this->validationRules = [
            'name' => 'required',
            'email' => 'required|email',
            'performance_location_id' => 'required|exists:performance_locations,id',
            'stages' => 'required|array',
            'time_slots' => 'required|array'
        ];
        $this->validationMessages = [
            'name.required' => 'Please enter event name',
            'email.numeric' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'performance_location_id.required' => 'Please select performance location',
            'performance_location_id.exists' => 'Invalid Performance location',
            'stages.required' => 'Please select at least 1 stage',
            'stages.array' => 'Invalid stages',
            'time_slots.required' => 'Please enter at least 1 time slot'
        ];
        $this->validateApiRequest();

        if ($this->isInputValid) {
            \DB::beginTransaction();
            try {
                if ($request->get('date')) {
                    $request->merge(
                        [
                            'date' => Carbon::createFromTimestampMs($request->get('date'))
                        ]
                    );
                }

                $event->fill(array_filter($request->only((new Event())->getFillable())))->save();
                $event->stages()->sync($request->get('stages'));

                $event->timeSlots()->delete();
                $timeSlots = [];
                foreach ($request->get('time_slots', []) as $timeSlot) {
                    $timeSlots[] = [
                        'start' => Carbon::createFromTimestampMs($timeSlot[0])->format('H:i:s'),
                        'end' => Carbon::createFromTimestampMs($timeSlot[1])->format('H:i:s')
                    ];
                }
                if ($timeSlots) {
                    $event->timeSlots()->createMany($timeSlots);
                }

                \DB::commit();
                $this->setResponseVars('Event updated');
            } catch (\Exception $exception) {
                \DB::rollBack();
                $this->setResponseVars('Something went wrong, please try again!');
            }
        }
        return $this->apiResponse();
    }
}
