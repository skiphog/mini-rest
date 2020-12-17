<?php

namespace App\Requests;

use System\Http\FormRequest;

class SightRequest extends FormRequest
{
    protected static $messages = [
        'city_id.custom' => 'Города с таким параметром не существует',
    ];

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'city_id'  => 'required|positive|custom:EntityExists~cities',
            'name'     => 'required|str|between:2,150',
            'distance' => 'required|positive'
        ];

        if (false === strpos($this->request->uri(), 'update')) {
            return $rules;
        }

        return [
            'id'       => 'required|positive|exists:sights',
            'city_id'  => 'positive|custom:EntityExists~cities',
            'name'     => 'str|between:2,150',
            'distance' => 'positive'
        ];
    }
}
