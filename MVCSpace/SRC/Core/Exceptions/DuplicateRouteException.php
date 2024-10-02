<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;

class DuplicateRouteException extends Exception
{

    /**
     * @param string $method
     * @param string $path
     */
    public function __construct(string $method, string $path)
    {
        parent::__construct("Route '$path' already exists for '$method'.");
    }
}