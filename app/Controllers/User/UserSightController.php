<?php

namespace App\Controllers\User;

use App\Models\Sight;
use System\Http\Response;
use App\Filters\SightFilter;
use System\Foundation\Controller;
use App\Requests\UserSightRequest;

class UserSightController extends Controller
{
    /**
     * @param UserSightRequest $request
     * @param SightFilter      $filter
     *
     * @return Response
     */
    public function show(UserSightRequest $request, SightFilter $filter): Response
    {
        $sights = Sight::select()
            ->withFilter($filter)
            ->join('travelings', 'sight_id', $request->input('id'))
            ->all();

        return json($sights);
    }
}
