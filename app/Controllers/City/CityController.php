<?php

namespace App\Controllers\City;

use App\Models\City;
use System\Http\Response;
use App\Filters\SightFilter;
use App\Requests\CityRequest;
use App\Requests\DestroyRequest;
use System\Foundation\Controller;
use System\Http\Exceptions\NotFoundException;

class CityController extends Controller
{
    /**
     * @param SightFilter $filter
     *
     * @return Response
     */
    public function index(SightFilter $filter): Response
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

        $city->fill($request)
            ->update();

        return json($city);
    }

    /**
     * @param DestroyRequest $request
     *
     * @return Response
     */
    public function delete(DestroyRequest $request): Response
    {
        $city = City::select()
            ->where(['id' => $request->input('id')])
            ->one();

        $result = $city->delete();

        return json(['result' => $result]);
    }
}
