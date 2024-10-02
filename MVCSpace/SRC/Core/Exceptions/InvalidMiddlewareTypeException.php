<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;
use MVCSpace\Core\Interface\IMiddleware;

class InvalidMiddlewareTypeException extends Exception
{

    /**
     * @param object $middleware
     */
    public function __construct(object $middleware)
    {
        $middleware = $middleware::class;
        $interface = IMiddleware::class;
        parent::__construct("The presumed middleware '$middleware' does not implement the '$interface' interface.");
    }
}