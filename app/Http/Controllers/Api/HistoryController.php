<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\HandleApiRequestAndResponse;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class HistoryController extends Controller
{
    use HandleApiRequestAndResponse;

    final public function index(Request $request)
    {
        $activities = Activity::with(['subject', 'causer']);

        $activities->orderBy(
            $request->get('sort-by') ?? 'created_at',
            $request->get('sort-dir') ?? 'desc'
        );

        $activities = $activities->paginate($request->get('per-page', 10));

        $activities->getCollection()
            ->transform(function($activity, $key) {
                return [
                    's_no' => $key + 1,
                    'event_name' => $activity->subject->name,
                    'user_name' => $activity->causer->name,
                    'artist_name' => $activity->properties['artist_name'],
                    'old_status' => $activity->properties['old'],
                    'new_status' => $activity->properties['new'],
                    'description' => $activity->description,
                    'created_at' => $activity->created_at->format('m-d-Y H:i:s')
                ];
            });

        $this->setResponseVars('History', $activities);
        return $this->apiResponse();
    }
}
