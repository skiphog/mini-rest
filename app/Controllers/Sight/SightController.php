<?php

namespace App\Controllers\Sight;

use App\Models\Sight;
use System\Http\Response;
use App\Filters\SightFilter;
use App\Requests\SightRequest;
use System\Foundation\Controller;
use System\Http\Exceptions\NotFoundException;

class SightController extends Controller
{
    /**
     * @param SightFilter $filter
     *
     * @return Response
     */
    public function index(SightFilter $filter): Response
    {
        $sights = Sight::select()
            ->withFilter($filter)
            ->all();

        return json($sights);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws NotFoundException
     */
    public function show($id): Response
    {
        $sight = Sight::select()
            ->where(['id' => $id])
            ->one();

        if (!$sight) {
            throw new NotFoundException('User not found');
        }

        return json($sight);
    }

    /**
     * @param SightRequest $request
     *
     * @return Response
     */
    public function create(SightRequest $request): Response
    {
        $id = Sight::create($request);

        return json(['id' => $id], 201);
    }

    /**
     * @param SightRequest $request
     *
     * @return Response
     */
    public function update(SightRequest $request): Response
    {
        $sight = Sight::select()
            ->where(['id' => $request->input('id')])
            ->one();

        $sight->fill($request)
            ->update();

        return json($sight);
    }
}
