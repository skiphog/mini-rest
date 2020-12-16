<?php

namespace App\Requests;

use System\Http\FormRequest;

class CityRequest extends FormRequest
{
    protected static $messages = [
        'name.required' => 'Укажите название города',
        'name.unique'   => 'Такой город уже существует',
    ];

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = ['name' => 'required|str|between:2,100|unique:cities'];

        if (false === strpos($this->request->uri(), 'update')) {
            return $rules;
        }

        $rules['id'] = 'required|positive|exists:cities';

        return $rules;
    }
}
