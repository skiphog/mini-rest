<?php

namespace App\Requests;

use System\Http\FormRequest;
use InvalidArgumentException;

class DestroyRequest extends FormRequest
{
    protected $targets = [
        'cities',
        'users',
        'sights'
    ];

    public function rules(): array
    {
        return ['id' => 'exists:' . $this->getTarget()];
    }

    /**
     * @return string
     */
    protected function getTarget(): string
    {
        $parts = explode('/', $this->request->uri());

        if (!in_array($target = array_shift($parts), $this->targets, true)) {
            throw new InvalidArgumentException('Передан неверный параметр в правила валидации');
        }

        return $target;
    }
}
