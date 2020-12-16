<?php

namespace App\Requests;

use System\Http\FormRequest;

class TravelRequest extends FormRequest
{
    protected static $messages = [

    ];

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id'  => 'required|positive|custom:EntityExists~users',
            'sight_id' => 'required|positive|custom:EntityExists~sights',
            'rate'     => 'required|positive|between:1,10'
        ];
    }
}
