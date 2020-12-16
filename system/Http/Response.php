<?php

namespace System\Http;


use InvalidArgumentException;

/**
 * Class Response
 *
 * @package System
 */
class Response
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @param mixed $data
     *
     * @return Response
     */
    public function setData($data): Response
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $url
     * @param int $code
     *
     * @return Response
     */
    public function redirect(string $url, $code = 302): Response
    {
        $this->setHeader('Location: ' . $url, $code);

        return $this;
    }


    /**
     * @param mixed $data
     * @param int $code
     *
     * @return Response
     */
    public function json($data, $code = 200): Response
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException(json_last_error_msg());
        }

        $this->setHeader('Content-Type: application/json;charset=utf-8', $code);

        return $this->setData($json);
    }


    /**
     * @param array $header
     * @param null $code
     * @param bool $replace
     *
     * @return Response
     */
    public function withHeaders(array $header, $code = null, $replace = false): Response
    {
        foreach ($header as $key => $value) {
            $this->setHeader($key . ': ' . $value, $code, $replace);
        }

        return $this;
    }

    /**
     * @param int $code
     *
     * @return Response
     */
    public function withCode(int $code): Response
    {
        http_response_code($code);

        return $this;
    }

    /**
     * Устанавливает заголовок
     *
     * @param string $header
     * @param null $code
     * @param bool $replace
     */
    protected function setHeader(string $header, $code = null, $replace = true): void
    {
        header($header, $replace, $code);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->data;
    }
}
