<?php

/**
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

use System\App;
use System\Http\Request;
use System\Http\Response;
use System\Database\Connection;
use System\Database\Exceptions\TransactionException;

/**
 * @param string $name
 *
 * @return mixed|object
 */
function app(string $name)
{
    return App::get($name);
}

/**
 * @param string|null $key
 *
 * @return mixed
 */
function config(?string $key = null)
{
    $config = app('global_config');

    return null === $key ? $config : $config[$key] ?? null;
}

/**
 * @param string|null $path
 *
 * @return string
 */
function root_path(?string $path = null): string
{
    static $root;

    return ($root ?: $root = app('root_path')) . $path;
}

/**
 * @return PDO
 */
function db(): PDO
{
    return app(Connection::class);
}

/**
 * @return Request
 */
function request(): Request
{
    return app(Request::class);
}

/**
 * @param mixed $data
 * @param int   $code
 *
 * @return Response
 */
function json($data, int $code = 200): Response
{
    return (new Response())
        ->json($data, $code);
}


/**
 * @param callable $callback
 *
 * @return bool
 */
function transaction(callable $callback): bool
{
    $db = db();

    try {
        $db->beginTransaction();
        $callback($db);

        return $db->commit();
    } catch (Throwable $e) {
        $db->rollBack();
        throw new TransactionException('Неудачная транзакция', 500, $e);
    }
}


/**
 * Проверка окружения на Local
 *
 * @noinspection SuspiciousBinaryOperationInspection
 * @return bool
 */
function isLocal(): bool
{
    static $env;

    return $env ?? $env = 'local' === config('env');
}


/**
 * Проверка окружения на Production
 *
 * @return bool
 */
function isProduction(): bool
{
    return !isLocal();
}

/**
 * @param mixed    $value
 * @param callable $callback
 *
 * @return mixed
 */
function tap($value, callable $callback)
{
    $callback($value);

    return $value;
}
