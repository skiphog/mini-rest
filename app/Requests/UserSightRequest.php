<?php

namespace App\Requests;

use System\Http\FormRequest;

class UserSightRequest extends FormRequest
{

    protected static $messages = [
        'id.exists'   => 'Юзера с таким ID не существует',
    ];

    /**
     * @return array
     */
    public function rules(): array
    {
        return ['id' => 'exists:users'];
    }
}
