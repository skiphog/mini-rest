<?php

namespace System\Foundation;

use Throwable;
use System\App;
use ReflectionMethod;
use ReflectionParameter;
use System\Http\Request;
use ReflectionNamedType;

/**
 * Class Controller
 *
 * @package System\Foundation
 */
abstract class Controller
{
    /**
     * @param string $action
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function callAction(string $action, Request $request)
    {
        $method = new ReflectionMethod($this, $action);

        $args = array_map(static function (ReflectionParameter $param) use ($request) {
            if (($type = $param->getType()) && $type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                return App::get($type->getName());
            }

            return $request->get($param->name);
        }, $method->getParameters());

        return $method->invokeArgs($this, $args);
    }
}
