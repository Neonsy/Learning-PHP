<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;

class ViewNotFoundException extends Exception
{

    /**
     * @param string $viewFile
     */
    public function __construct(string $viewFile)
    {
        parent::__construct("View '$viewFile' not found");
    }
}