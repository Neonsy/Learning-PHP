<?php

declare(strict_types=1);

namespace MVCSpace\Core\Exceptions;

use Exception;
use MVCSpace\Core\Interface\Controller\IDelete;
use MVCSpace\Core\Interface\Controller\IGet;
use MVCSpace\Core\Interface\Controller\IPost;
use MVCSpace\Core\Interface\Controller\IPut;

class InvalidControllerActionException extends Exception
{

    /**
     * @param IDelete|IGet|IPost|IPut $controller
     * @param string $action
     */
    public function __construct(IDelete|IGet|IPost|IPut $controller, string $action)
    {
        $controller = $controller::class;

        parent::__construct("The controller '$controller' is missing the required '$action' action.");
    }
}