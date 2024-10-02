<?php

declare(strict_types=1);

namespace MVCSpace\Model;

use MVCSpace\Core\Service\Container;
use MVCSpace\Core\Service\Services\Database;

class Base
{
    /**
     * @var Database $db Holds the DB wrapper for specific models.
     */
    protected Database $db;

    public function __construct()
    {
        $this->db = Container::getInstance()->get('db');
    }
}