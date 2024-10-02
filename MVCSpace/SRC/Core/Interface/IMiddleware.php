<?php

declare(strict_types=1);

namespace MVCSpace\Core\Interface;

use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;

/**
 * Every middleware must implement this interface to ensure functionality.
 *
 * Invoke Magic Method will be used when an object is called like a function.
 * @see https://www.php.net/manual/en/language.oop5.magic.php#object.invoke
 */
interface IMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next): void;
}