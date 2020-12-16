<?php

namespace App\Controllers\User;

use System\Http\Response;
use App\Requests\TravelRequest;
use System\Foundation\Controller;

class UserTravelController extends Controller
{
    public function create(TravelRequest $request): Response
    {
        return json($request->input(), 201);
    }
}
