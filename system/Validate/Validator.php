<?php

namespace System\Validate;

use ReflectionClass;
use ReflectionException;

/**
 * Class Validator
 *
 * @package System
 */
abstract class Validator
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var array
     */
    protected $messages;

    /**
     * @var string|null
     */
    protected $params;

    /**
     * Validator constructor.
     *
     * @param string $field
     * @param array $messages
     * @param null $params
     */
    public function __construct($field, $messages = [], $params = null)
    {
        $this->messages = $messages;
        $this->field = $field;
        $this->params = $params;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function process($value)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return $this->validate($value);
    }

    abstract public function validate($value);

    /**
     * @param string $text
     *
     * @return string
     */
    protected function getMessage($text): string
    {
        try {
            $field = $this->field . '.' . lcfirst((new ReflectionClass($this))->getShortName());
        } catch (ReflectionException $e) {
            $field = null;
        }

        return $this->messages[$field] ?? $text;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function __invoke($value)
    {
        return $this->process($value);
    }
}
