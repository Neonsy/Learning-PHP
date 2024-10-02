<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;

class InvalidControllerException extends Exception
{

    /**
     * @param string $controller
     */
    public function __construct(string $controller)
    {
        parent::__construct("The controller '$controller' does not exist.");
    }
}