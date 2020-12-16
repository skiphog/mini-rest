<?php

namespace App\Controllers\User;

use App\Models\User;
use System\Http\Response;
use App\Requests\UserRequest;
use System\Foundation\Controller;
use System\Http\Exceptions\NotFoundException;

class UserController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $users = User::select()
            ->all();

        return json($users);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws NotFoundException
     */
    public function show($id): Response
    {
        $sight = User::select()
            ->where(['id' => $id])
            ->one();

        if (!$sight) {
            throw new NotFoundException('Нет юзера с таким параметром');
        }

        return json($sight);
    }
    /**
     * @param UserRequest $request
     *
     * @return Response
     */
    public function create(UserRequest $request): Response
    {
        $id = User::create($request);

        return json(['id' => $id], 201);
    }

    /**
     * @param UserRequest $request
     *
     * @return Response
     */
    public function update(UserRequest $request): Response
    {
        $city = User::select()
            ->where(['id' => $request->input('id')])
            ->one();

        $city->update($request);

        return json($city);
    }
}
