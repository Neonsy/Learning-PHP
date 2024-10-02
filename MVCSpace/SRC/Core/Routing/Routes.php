<?php

declare(strict_types=1);

namespace MVCSpace\Core\Routing;

use MVCSpace\Core\App;
use MVCSpace\Core\Exceptions\DuplicateRouteException;
use MVCSpace\Core\Middleware\Routes\IsGuest;
use MVCSpace\Core\Middleware\Routes\IsUser;

/**
 * Registers all the routes for the different types.
 *
 * This mainly serves for better overview.
 */
class Routes
{
    public static function register(Router $router): void
    {
        try {
            $router->get('/', 'Index')->middleware(new IsUser());
            $router->get('/login', 'Login')->middleware(new IsUser());
            $router->post('/login', 'Login')->middleware(new IsUser());
            $router->get('/register', 'Register')->middleware(new IsUser());
            $router->post('/register', 'Register')->middleware(new IsUser());
            $router->get('/account', 'Account')->middleware(new IsGuest());
            $router->delete('/account', 'Account')->middleware(new IsGuest());
            $router->put('/account', 'Account')->middleware(new IsGuest());
            $router->get('/logout', 'Logout')->middleware(new IsGuest());
            $router->get('/notes', 'Notes/Index')->middleware(new IsGuest());
            $router->get('/note/create', 'Notes/Create')->middleware(new IsGuest());
            $router->post('/note/create', 'Notes/Create')->middleware(new IsGuest());
            $router->get('/note/:id', 'Notes/Show')->middleware(new IsGuest());
            $router->get('/note/edit/:id', 'Notes/Edit')->middleware(new IsGuest());
            $router->put('/note/edit/:id', 'Notes/Edit')->middleware(new IsGuest());
            $router->delete('/note/delete/:id', 'Notes/Delete')->middleware(new IsGuest());
        } catch (DuplicateRouteException $e) {
            App::dump($e->getMessage(), exit: true);
        }
    }
}