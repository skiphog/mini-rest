<?php

namespace App\Controllers\City;

use App\Models\User;
use App\Filters\UserFilter;
use App\Requests\CityUserRequest;
use System\Foundation\Controller;

class CityUserController extends Controller
{
    public function show(CityUserRequest $request, UserFilter $filter)
    {
        $users = User::select()
            ->distinct()
            ->withFilter($filter)
            ->joinOn('travelings', 'users.id', 'user_id')
            ->joinOn('sights', 'travelings.sight_id', 'id')
            ->equals('sights', 'city_id', $request->input('id'))
            ->all();

        return json($users);
    }
}
