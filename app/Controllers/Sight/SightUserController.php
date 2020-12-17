<?php

namespace App\Controllers\Sight;

use App\Models\User;
use App\Filters\UserFilter;
use System\Foundation\Controller;
use App\Requests\SightUserRequest;

class SightUserController extends Controller
{
    public function show(SightUserRequest $request, UserFilter $filter)
    {
        $users = User::select()
            ->distinct()
            ->withFilter($filter)
            ->joinOn('travelings', 'users.id', 'user_id')
            ->joinOn('sights', 'travelings.sight_id', 'id')
            ->equals('sights', 'id', $request->input('id'))
            ->all();

        return json($users);
    }
}
