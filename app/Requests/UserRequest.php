<?php

namespace App\Requests;

use System\Http\FormRequest;

class UserRequest extends FormRequest
{
    protected static $messages = [
        'name.required' => 'Укажите имя юзера',
    ];

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = ['name' => 'required|str|between:2,100|unique:users'];

        if (false === strpos($this->request->uri(), 'update')) {
            return $rules;
        }

        $rules['id'] = 'required|positive|exists:users';

        return $rules;
    }
}
