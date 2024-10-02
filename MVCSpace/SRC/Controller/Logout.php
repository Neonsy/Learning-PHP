<?php

declare(strict_types=1);

namespace MVCSpace\Controller;

use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IGet;
use MVCSpace\Core\Service\Container;
use MVCSpace\Core\Service\Services\SessionManager;

class Logout implements IGet
{
    public function getAction(Request $request, Response $response, array $params): void
    {
        /** @var SessionManager $sm */
        $sm = Container::getInstance()->get('sm');

        $sm->destroy();

        $response->redirect('/');
    }
}