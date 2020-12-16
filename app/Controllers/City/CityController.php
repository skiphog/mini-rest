<?php

namespace App\Controllers\City;

use App\Models\City;
use System\Http\Response;
use App\Filters\CityFilter;
use App\Requests\CityRequest;
use System\Foundation\Controller;
use System\Http\Exceptions\NotFoundException;

class CityController extends Controller
{
    /**
     * @param CityFilter $filter
     *
     * @return Response
     */
    public function index(CityFilter $filter): Response
    {
        $cities = City::select()
            ->withFilter($filter)
            ->all();

        return json($cities);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws NotFoundException
     */
    public function show($id): Response
    {
        $city = City::select()
            ->where(['id' => $id])
            ->one();

        if (!$city) {
            throw new NotFoundException('Нет такого города');
        }

        return json($city);
    }

    /**
     * @param CityRequest $request
     *
     * @return Response
     */
    public function create(CityRequest $request): Response
    {
        $id = City::create($request);

        return json(['id' => $id], 201);
    }

    /**
     * @param CityRequest $request
     *
     * @return Response
     */
    public function update(CityRequest $request): Response
    {
        $city = City::select()
            ->where(['id' => $request->input('id')])
            ->one();

        $city->update($request);

        return json($city);
    }
}
