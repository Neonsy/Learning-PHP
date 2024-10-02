<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;

class NoRoutesForRequestMethodException extends Exception
{

    /**
     * @param string $method
     */
    public function __construct(string $method)
    {
        parent::__construct("No routes registered under the '$method' request method.");
    }
}