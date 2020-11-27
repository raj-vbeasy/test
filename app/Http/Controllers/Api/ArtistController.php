<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Traits\HandleApiRequestAndResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtistController extends Controller
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
        $artist = Artist::query();

        if ($request->get('filter')) {
            $artist->where('name', 'LIKE', "{$request->get('filter')}%");
        }

        if ($request->get('event')) {
            $artist->whereDoesntHave('events', function (Builder $builder) use ($request){
                $builder->where('event_id', $request->get('event'));
            });
        }
        
        $sortBy = $request->get('sort-by') ?? 'updated_at';
        $sortDir = $request->get('sort-dir') ?? 'desc';
        
        $artist->orderBy($sortBy, $sortDir);
        
        $this->setResponseVars(
            'List of Artist',
            $artist->paginate($request->get('per-page', 10))
        );
        return $this->apiResponse();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
