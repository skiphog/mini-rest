<?php

namespace App\Controllers\City;

use App\Models\City;
use App\Models\Sight;
use System\Http\Response;
use App\Filters\SightFilter;
use System\Foundation\Controller;
use App\Requests\CitySightRequest;

class CitySightController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $cities = City::select()
            ->withModel(Sight::class);

        return json($cities);
    }

    /**
     * @param CitySightRequest $request
     * @param SightFilter  $filter
     *
     * @return Response
     */
    public function show(CitySightRequest $request, SightFilter $filter): Response
    {
        $sights = Sight::select()
            ->withFilter($filter)
            ->where(['city_id' => $request->input('id')])
            ->all();

        return json($sights);
    }
}
