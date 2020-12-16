<?php

namespace System\Http;

use Traversable;
use ArrayIterator;
use IteratorAggregate;
use System\Http\Exceptions\MultiException;
use System\Validate\Exceptions\RuleException;
use System\Validate\Exceptions\ValidateException;

/**
 * Class FormRequest
 *
 * @mixin Request
 *
 * @package System\Http
 */
abstract class FormRequest implements IteratorAggregate
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var MultiException
     */
    protected $multi;

    /**
     * @var array
     */
    protected static $messages = [];

    /**
     * @var array
     */
    protected $validated_fields = [];

    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * FormRequest constructor.
     *
     * @param Request $request
     * @param MultiException $multi
     *
     * @throws MultiException
     */
    public function __construct(Request $request, MultiException $multi)
    {
        $this->request = $request;
        $this->multi = $multi;
        $this->process();
    }

    /**
     * @throws MultiException
     */
    protected function process(): void
    {
        $data = $this->request->all();

        foreach ($this->rules() as $key => $rules) {
            $value = $this->getValue($data, $key);

            foreach (explode('|', $rules) as $rule) {
                $args = null;
                if (false !== strpos($rule, ':')) {
                    if (substr_count($rule, ':') > 1) {
                        throw new RuleException("Ошибка правила валидации [:] в {$rules}");
                    }

                    [$rule, $args] = explode(':', $rule);
                }

                $validator = 'System\\Validate\\Validation\\' . ucfirst($rule);

                if (!class_exists($validator)) {
                    throw new RuleException("Ошибка правила валидации [{$rule}] в {$rules}");
                }

                try {
                    $value = (new $validator($key, static::$messages, $args))($value);
                } catch (ValidateException $e) {
                    $this->multi->add($key, $e);
                    break;
                }
            }

            null !== $value && $this->validated_fields[$key] = $value;
        }

        if (!$this->multi->isEmpty()) {
            throw $this->multi;
        }

        $this->request->setAttributes($this->validated_fields);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->request->{$name}(...$arguments);
    }

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->request->all());
    }

    public function __get($name)
    {
        return $this->request->input($name);
    }

    public function __set($name, $value)
    {
        $this->request->setAttributes($name, $value);
    }

    public function __isset($name): bool
    {
        return $this->request->has($name);
    }

    /**
     * @param array $data
     * @param $key
     *
     * @return mixed
     */
    protected function getValue(array $data, $key)
    {
        if (isset($data[$key])) {
            return is_array($data[$key]) ? $data[$key] : trim($data[$key]);
        }

        return null;
    }
}
