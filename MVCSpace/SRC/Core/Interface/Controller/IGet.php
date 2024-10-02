<?php

declare(strict_types=1);

namespace MVCSpace\Core\Interface\Controller;

use MVCSpace\Core\Exceptions\ViewNotFoundException;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;

interface IGet
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $params
     * @return void
     * @throws ViewNotFoundException
     */
    public function getAction(Request $request, Response $response, array $params): void;
}