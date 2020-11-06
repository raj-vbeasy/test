<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PerformanceLocation;
use App\Models\Timezone;
use App\Traits\HandleApiRequestAndResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class PerformanceLocationController extends Controller
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
        $performanceLocations = PerformanceLocation::query();
        if ($request->get('filter')) {
            $performanceLocations->where(function (Builder $builder) use ($request){
               $builder->where('name', 'LIKE', "%{$request->get('filter')}%")
                   ->orWhere('location', 'LIKE', "%{$request->get('filter')}%");
            });
        }
        if ($request->get('sort-by')) {
            $dir = $request->get('sort-dir') ?? 'desc';
            $performanceLocations->orderBy($request->get('sort-by'), $dir);
        }
        $this->setResponseVars(
            'List of Performance Locations',
            $performanceLocations->paginate($request->get('per-page', 10))
        );
        return $this->apiResponse();
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    final public function create(): JsonResponse
    {
        $this->setResponseVars(
            'Form Data',
            [
                'timezones' => Timezone::select(['id as value', 'name as label'])->get(),
                'currencies' => [['value' => 1, 'label' => 'USD']],
                'event_templates' => [['value' => 1, 'label' => 'Test Template']],
                'logos' => [['value' => 1, 'label' => 'Test logo']]
            ]
        );
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
        \DB::beginTransaction();
        try {
            PerformanceLocation::create(array_filter($request->only((new PerformanceLocation())->getFillable())));
            \DB::commit();
            $this->setResponseVars('Added new performance location');
        } catch (\Exception $exception) {
            \DB::rollBack();
            $this->setResponseVars('Something went wrong, please try again!');
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
        if ($performanceLocation = PerformanceLocation::find($id)) {
            $this->setResponseVars(
                'Edit performance location',
                [
                    'performance_location' => $performanceLocation,
                    'timezones' => Timezone::select(['id as value', 'name as label'])->get(),
                    'currencies' => [['value' => 1, 'label' => 'USD']],
                    'event_templates' => [['value' => 1, 'label' => 'Test Template']],
                    'logos' => [['value' => 1, 'label' => 'Test logo']]
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
        if ($performanceLocation = PerformanceLocation::find($id)) {
            \DB::beginTransaction();
            try {
                $performanceLocation->fill(
                    array_filter($request->only((new PerformanceLocation())->getFillable()))
                )->save();
                \DB::commit();
                $this->setResponseVars('Updated performance location');
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
        if ($performanceLocation = PerformanceLocation::find($id)) {
            $performanceLocation->delete();
            $this->setResponseVars('Successfully Deleted');
        } else {
            $this->setResponseVars('Not Found', Response::HTTP_NOT_FOUND);
        }
        return $this->apiResponse();
    }
}
