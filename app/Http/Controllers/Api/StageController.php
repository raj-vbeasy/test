<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PerformanceLocation;
use App\Models\Stage;
use App\Traits\HandleApiRequestAndResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

use function foo\func;

class StageController extends Controller
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
        $stage = Stage::with('performanceLocation');
    
        if ($eventId = $request->get('event_id')) {
            $stage->whereHas('events', function (Builder $builder) use ($eventId){
                $builder->where('event_id', $eventId);
            });
        }
        
        if ($filter = $request->get('filter')) {
            $stage->where(function (Builder $builder) use ($filter) {
                $builder->whereHas('performanceLocation', function (Builder $builder) use ($filter) {
                    $builder->where('name', 'LIKE', "%{$filter}%")
                        ->orWhere('location', 'LIKE', "%{$filter}%");
                })->orWhere('name', 'LIKE', "%{$filter}%");
            });
        }
        if ($request->get('sort-by')) {
            $dir = $request->get('sort-dir') ?? 'desc';
            $stage->orderBy($request->get('sort-by'), $dir);
        }
        
        $this->setResponseVars(
            'List of Stages',
            $stage->paginate($request->get('per-page', 10))
        );
        return $this->apiResponse();
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    final public function create(Request $request): JsonResponse
    {
        $query = PerformanceLocation::select(['id as value', 'name as label']);
        if ($eventId = $request->get('event_id')) {
            $query->whereHas('events', function (Builder $builder) use ($eventId) {
                $builder->where('id', $eventId);
            });
        }
        $performanceLocations = $query->get();
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
        $performanceLocation = PerformanceLocation::find($request->get('performance_location_id'));
        if ($performanceLocation) {
            \DB::beginTransaction();
            try {
                $stage = $performanceLocation->stages()->create(array_filter($request->only((new Stage())->getFillable())));
                if ($eventId = $request->get('event_id')) {
                    Event::find($eventId)->stages()->syncWithoutDetaching($stage);
                }
                \DB::commit();
                $this->setResponseVars('Added new stage for performance location');
            } catch (\Exception $exception) {
                \DB::rollBack();
                $this->setResponseVars('Something went wrong, please try again!');
            }
        } else {
            $this->setResponseVars('parameter error', null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->apiResponse();
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    final public function edit(int $id): JsonResponse
    {
        if ($stage = Stage::with('performanceLocation:id,name')->find($id)) {
            $this->setResponseVars(
                'Edit stage',
                [
                    'stage' => $stage,
                    'performance_locations' => PerformanceLocation::select(['id as value', 'name as label'])->get()
                ]
            );
        } else {
            $this->setResponseVars('Invalid ID', null, Response::HTTP_NOT_FOUND);
        }
        return $this->apiResponse();
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    final public function update(Request $request, int $id): JsonResponse
    {
        if ($stage = Stage::find($id)) {
            \DB::beginTransaction();
            try {
                $stage->fill(
                    array_filter($request->only((new Stage())->getFillable()))
                )->save();
                \DB::commit();
                $this->setResponseVars('Updated stage');
            } catch (\Exception $exception) {
                \DB::rollBack();
                $this->setResponseVars('Something went wrong, please try again!');
            }
        } else {
            $this->setResponseVars('Not Found', Response::HTTP_NOT_FOUND);
        }
        
        return $this->apiResponse();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    final public function destroy(int $id): JsonResponse
    {
        if ($stage = Stage::find($id)) {
            $stage->fill(['status' => 1])->save();
            $this->setResponseVars('Successfully Deleted');
        } else {
            $this->setResponseVars('Not Found', Response::HTTP_NOT_FOUND);
        }
        return $this->apiResponse();
    }
}
