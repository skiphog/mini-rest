<?php

namespace System\Database;

use System\Http\FormRequest;

/**
 * Class Model
 *
 * @property int $id
 *
 * @package System\Database
 */
abstract class Model
{

    protected $fillable = [];

    /**
     * @return Builder
     */
    public static function select(): Builder
    {
        return (new Builder(static::class))
            ->select();
    }

    /**
     * @param FormRequest $request
     *
     * @return int
     */
    public static function create(FormRequest $request): int
    {
        return (new Builder(static::class))
            ->insert($request);
    }

    /**
     * @param FormRequest $request
     *
     * @return Model
     */
    public function update(FormRequest $request): Model
    {
        $this->fill($request);

        return (new Builder(static::class))
            ->update($this);
    }

    /**
     * Заполняет модель значениями
     *
     * @param iterable $data
     *
     * @return $this
     */
    public function fill(iterable $data): self
    {
        foreach ($data as $key => $value) {
            in_array($key, $this->fillable, true) && $this->{$key} = $value;
        }

        return $this;
    }


    /**
     * @return array
     */
    public function asArray(): array
    {
        $data = [];

        foreach ($this->fillable as $name) {
            $data[$name] = $this->{$name};
        }

        return $data;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->{$name});
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    public function __set(string $name, $value)
    {
        if (method_exists($this, $method = $this->generateMethod('set', $name))) {
            return $this->$method($value);
        }

        return $this->specialSet($name, $value);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        if (method_exists($this, $method = $this->generateMethod('get', $name))) {
            return $this->$method($name);
        }

        return null;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    protected function specialSet(string $name, $value)
    {
        return $this->{$name} = $value;
    }

    /**
     * Генерирует метод
     *
     * @param string $particle
     * @param string $data
     *
     * @return string
     */
    protected function generateMethod(string $particle, string $data): string
    {
        $method = array_map('ucfirst', explode('_', $data));

        return $particle . implode('', $method);
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function setId($value): int
    {
        return $this->{'id'} = (int)$value;
    }
}
