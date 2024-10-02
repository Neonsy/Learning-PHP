<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;

class DuplicateServiceException extends Exception
{

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct("There's already another service registered under the '$key' key.");
    }
}