<?php

declare(strict_types=1);

namespace MVCSpace\Controller\Notes;

use MVCSpace\Core\App;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IGet;
use MVCSpace\Core\Service\Container;
use MVCSpace\Core\Service\Services\SessionManager;
use MVCSpace\Model\Note;

class Index implements IGet
{

    public function getAction(Request $request, Response $response, array $params): void
    {
        /** @var SessionManager $sm */
        $sm = Container::getInstance()->get('sm');

        $noteModel = new Note();
        $notes = $noteModel->getAll($sm->get('id'));

        $response->specifyContent(App::render('Notes/index',
            [
                'title' => 'Notes',
                'notes' => $notes,
            ]));
    }
}