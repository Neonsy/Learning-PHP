<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;

class InvalidContentTypeException extends Exception
{

    /**
     * @param string|null $contentType
     */
    public function __construct(?string $contentType)
    {
        parent::__construct("The content type '$contentType' is not valid.");
    }
}