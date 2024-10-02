<?php

declare(strict_types=1);

namespace MVCSpace\Controller\Notes;

use MVCSpace\Core\App;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IGet;
use MVCSpace\Core\Interface\Controller\IPost;
use MVCSpace\Core\Service\Container;
use MVCSpace\Core\Service\Services\SessionManager;
use MVCSpace\Core\Utils\InputValidator;
use MVCSpace\Model\Note;

class Create implements IGet, IPost
{

    public function getAction(Request $request, Response $response, array $params): void
    {
        $response->specifyContent(App::render('Notes/create',
            [
                'title' => 'Create'
            ]));
    }

    public function postAction(Request $request, Response $response, array $params): void
    {
        extract($request->getPayload());

        $title = filter_var($title, FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_var($content, FILTER_SANITIZE_SPECIAL_CHARS);

        if (InputValidator::invalidNote($title, $content)) {
            $response->redirect("/note/create", true);
        }

        /** @var SessionManager $sm */
        $sm = Container::getInstance()->get('sm');

        $noteModel = new Note();
        $noteModel->add($sm->get('id'), $title, $content);

        $response->redirect('/notes');
    }
}