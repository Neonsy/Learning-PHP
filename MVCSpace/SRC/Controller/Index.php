<?php

declare(strict_types=1);

namespace MVCSpace\Controller;

use MVCSpace\Core\App;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IGet;

class Index implements IGet
{

    public function getAction(Request $request, Response $response, array $params): void
    {
        $response->specifyContent(App::render('home',
            [
                'title' => 'Home',
            ]));
    }
}