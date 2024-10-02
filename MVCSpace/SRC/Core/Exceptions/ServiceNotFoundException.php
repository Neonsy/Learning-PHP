<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;

class ServiceNotFoundException extends Exception
{

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct("Service '$key' not found.");
    }
}