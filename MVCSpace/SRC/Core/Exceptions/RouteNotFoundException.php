<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;

class RouteNotFoundException extends Exception
{

    /**
     * @param string $requestRoute
     */
    public function __construct(string $requestRoute)
    {
        parent::__construct("The requested route '$requestRoute' could not be located.");
    }
}