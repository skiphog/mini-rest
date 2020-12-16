<?php

namespace System\Http;

use function in_array;
use function is_array;
use function is_string;

/**
 * Class Request
 *
 * @package System
 */
class Request
{
    /**
     * @var array
     */
    protected $get;

    /**
     * @var array
     */
    protected $post;

    /**
     * @var array|null
     */
    protected $all;

    /**
     * @var array|null
     */
    protected $headers;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
    }

    /**
     * @param array $data [GET, POST]
     * @param mixed $params [void, string, array]
     *
     * @return array|string|null
     */
    protected function getData(array $data, $params)
    {
        if (null === $params) {
            return $data;
        }

        if (is_string($params)) {
            return $data[$params] ?? null;
        }

        $result = [];

        foreach ((array)$params as $arg) {
            $result[$arg] = $data[$arg] ?? null;
        }

        return $result;
    }

    /**
     * @param mixed $params
     *
     * @return string|array|null
     */
    public function headers($params = null)
    {
        if (null === $this->headers) {
            $this->headers = $this->getHttpHeaders();
        }

        if ($params !== null) {
            $params = strtoupper(str_replace('-', '_', $params));
        }

        return $this->getData($this->headers, $params);
    }

    /**
     * @return array
     */
    protected function getHttpHeaders(): array
    {
        $headers = [];

        array_walk($_SERVER, static function ($value, $key) use (&$headers) {
            0 === strpos($key, 'HTTP_') && $headers[substr($key, 5)] = $value;
        });

        return $headers;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        if (null === $this->all) {
            $this->all = array_merge($this->get(), $this->post());
        }

        return $this->all;
    }

    /**
     * @param mixed $params
     *
     * @return mixed
     */
    public function post($params = null)
    {
        return $this->getData($this->post, $params);
    }

    /**
     * @param mixed $params
     *
     * @return mixed
     */
    public function get($params = null)
    {
        return $this->getData($this->get, $params);
    }

    /**
     * @param array|string $params
     *
     * @return array
     */
    public function except($params): array
    {
        $params = (array)$params;

        return array_filter($this->all(), static function ($key) use (&$params) {
            return !in_array($key, $params, true);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @return string
     */
    public function uri(): string
    {
        $uri = ltrim($_SERVER['REQUEST_URI'], '/');

        return (false !== $pos = strpos($uri, '?')) ? substr($uri, 0, $pos) : $uri;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param $name
     *
     * @return array|string|null
     */
    public function __get($name)
    {
        return $this->input($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->setAttributes($name, $value);
    }

    /**
     * @param mixed $params
     *
     * @return string|array|null
     */
    public function input($params = null)
    {
        $all = $this->all();

        return $this->getData($all, $params);
    }

    /**
     * @param string|array $name
     * @param string|null $value
     *
     * @return Request
     */
    public function setAttributes($name, $value = null): Request
    {
        $this->all = null;

        foreach (is_array($name) ? $name : [$name => $value] as $key => $item) {
            is_string($key) && $this->get[$key] = $item;
        }

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $targets
     *
     * @return Request
     */
    public function deleteAttribute(string $name, $targets = null): Request
    {
        $this->all = null;
        $vars = get_object_vars($this);

        if ($targets === null) {
            foreach ($vars as $key => $var) {
                if (is_array($var) && array_key_exists($name, $var)) {
                    unset($this->{$key}[$name]);
                }
            }

            return $this;
        }

        foreach ((array)$targets as $target) {
            if (isset($vars[$target]) && is_array($vars[$target]) && array_key_exists($name, $vars[$target])) {
                unset($this->{$target}[$name]);
            }
        }

        return $this;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name): bool
    {
        return $this->has($name);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->all());
    }
}
