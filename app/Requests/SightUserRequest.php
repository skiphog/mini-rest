<?php

namespace App\Requests;

use System\Http\FormRequest;

class SightUserRequest extends FormRequest
{

    protected static $messages = [
        'id.exists'   => 'Достопримечательности с таким ID не существует',
    ];

    /**
     * @return array
     */
    public function rules(): array
    {
        return ['id' => 'exists:sights'];
    }
}
