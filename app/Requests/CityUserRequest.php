<?php

namespace App\Requests;

use System\Http\FormRequest;

class CityUserRequest extends FormRequest
{
    protected static $messages = [
        'id.exists'   => 'Горда с таким ID не существует',
    ];

    /**
     * @return array
     */
    public function rules(): array
    {
        return ['id' => 'exists:cities'];
    }
}
