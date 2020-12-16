<?php

namespace App\Controllers\User;

use App\Models\Travel;
use System\Http\Response;
use App\Requests\TravelRequest;
use System\Foundation\Controller;

class UserTravelController extends Controller
{
    public function create(TravelRequest $request): Response
    {
        $id = Travel::create($request);

        return json(['id' => $id], 201);
    }
}
