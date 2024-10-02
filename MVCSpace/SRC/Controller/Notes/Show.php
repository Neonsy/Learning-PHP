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

class Show implements IGet
{
    public function getAction(Request $request, Response $response, array $params): void
    {
        $noteModel = new Note();
        /** @var SessionManager $sm */
        $sm = Container::getInstance()->get('sm');

        $note = $noteModel->get((int)$params['id'], $sm->get('id'));

        if (!$note) {
            $response->redirect('/notes');
        }

        $response->specifyContent(App::render('Notes/show',
            [
                'title' => $note['title'],
                'note' => $note
            ]));
    }
}