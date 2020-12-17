<?php

namespace App\Controllers\User;

use App\Models\User;
use System\Http\Response;
use App\Requests\UserRequest;
use App\Requests\DestroyRequest;
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
        $user = User::select()
            ->where(['id' => $request->input('id')])
            ->one();

        $user->fill($request)
            ->update();

        return json($user);
    }

    /**
     * @param DestroyRequest $request
     *
     * @return Response
     */
    public function delete(DestroyRequest $request): Response
    {
        $user = User::select()
            ->where(['id' => $request->input('id')])
            ->one();

        $result = $user->delete();

        return json(['result' => $result]);
    }
}
