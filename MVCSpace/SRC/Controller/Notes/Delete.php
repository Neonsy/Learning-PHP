<?php

declare(strict_types=1);

namespace MVCSpace\Controller\Notes;

use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IDelete;
use MVCSpace\Core\Service\Container;
use MVCSpace\Core\Service\Services\SessionManager;
use MVCSpace\Model\Note;

class Delete implements IDelete
{
    public function deleteAction(Request $request, Response $response, array $params): void
    {
        $noteModel = new Note();

        /** @var SessionManager $sm */
        $sm = Container::getInstance()->get('sm');

        $noteModel->delete((int)$params['id'], $sm->get('id'));

        $response->redirect('/notes', true);
    }
}