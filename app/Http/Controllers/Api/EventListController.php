<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PerformanceLocation;
use App\Traits\HandleApiRequestAndResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;
use App\Http\Resources\Event as EventResource;
use Illuminate\Support\Facades\DB;

class EventListController extends Controller
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
        $events = Event::with(['performanceLocation']);// 'stages', 'artists', 'activities.stage', 'activities.artist', 'expenses']);

        if ($filter = $request->get('filter')) {
            $events->where(function (Builder $builder) use ($filter) {
                $builder->whereHas('performanceLocation', function (Builder $builder) use ($filter) {
                    $builder->where('name', 'LIKE', "%{$filter}%")
                        ->orWhere('email', 'LIKE', "%{$filter}%")
                    ->orWhere('promoter', 'LIKE', "%{$filter}%")
                    ->orWhere('status', 'LIKE', "%{$filter}%");
                })->orWhere('date', 'LIKE', "%{$filter}%");
            });
        }
        if ($request->get('sort-by')) {
            $dir = $request->get('sort-dir') ?? 'desc';
            $events->orderBy($request->get('sort-by'), $dir);
        }

        $this->setResponseVars(
            'List of Events',
            $events->paginate($request->get('per-page', 10))
        );

        return $this->apiResponse();
    }

    final public function create(Request $request): JsonResponse
    {
        $artists = DB::table('artist_event')
            ->leftJoin('events', 'artist_event.event_id', '=', 'events.id')
            ->leftJoin('artists', 'artist_event.artist_id', '=', 'artists.id')
            ->where('artist_event.status', '=', 3)
            ->select('artist_event.*', 'events.name as event', 'events.date as event_date', 'events.status as event_status', 'artists.name as artist_name');

        if ($filter = $request->get('filter')) {
            $artists->where(function (Builder $builder) use ($filter) {
                $builder->whereHas('events.name', function (Builder $builder) use ($filter) {
                    $builder->where('events.status', 'LIKE', "%{$filter}%")
                        ->orWhere('artists.name', 'LIKE', "%{$filter}%");
                })->orWhere('date', 'LIKE', "%{$filter}%");
            });
        }

        if ($request->get('sort-by')) {
            $dir = $request->get('sort-dir') ?? 'desc';
            $artists->orderBy($request->get('sort-by'), $dir);
        }

        $this->setResponseVars(
            'List',
            $artists->paginate($request->get('per-page', 10))
        );

        return $this->apiResponse();
    }

}
