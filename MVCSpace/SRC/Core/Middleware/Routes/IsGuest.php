<?php

declare(strict_types=1);

namespace MVCSpace\Core\Middleware\Routes;

use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\IMiddleware;
use MVCSpace\Core\Service\Container;
use MVCSpace\Core\Service\Services\SessionManager;

/**
 * Middleware to prevent Guests from accessing the app routes
 */
class IsGuest implements IMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next): void
    {
        /** @var SessionManager $sm */

        $sm = Container::getInstance()->get('sm');

        if (!$sm->has('id')) {
            $response->redirect('/');
        }

        $next($request, $response);
    }
}