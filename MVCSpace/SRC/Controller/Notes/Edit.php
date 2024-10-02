<?php

declare(strict_types=1);

namespace MVCSpace\Controller\Notes;

use MVCSpace\Core\App;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IGet;
use MVCSpace\Core\Interface\Controller\IPut;
use MVCSpace\Core\Service\Container;
use MVCSpace\Core\Service\Services\SessionManager;
use MVCSpace\Core\Utils\InputValidator;
use MVCSpace\Model\Note;

class Edit implements IGet, IPut
{
    private Note $noteModel;
    private SessionManager $sm;

    public function __construct()
    {
        $this->noteModel = new Note();
        $this->sm = Container::getInstance()->get('sm');
    }

    public function getAction(Request $request, Response $response, array $params): void
    {
        $note = $this->noteModel->get((int)$params['id'], $this->sm->get('id'));

        if (!$note) {
            $response->redirect('/notes');
        }

        $response->specifyContent(App::render('Notes/edit',
            [
                'title' => 'Notes',
                'note' => $note
            ]));
    }

    public function putAction(Request $request, Response $response, array $params): void
    {
        extract($request->getPayload());

        $title = filter_var($title, FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_var($content, FILTER_SANITIZE_SPECIAL_CHARS);

        if (InputValidator::invalidNote($title, $content)) {
            $response->redirect("/note/$params[id]", true);
        }

        $this->noteModel->update((int)$params['id'], $title, $content);
        $response->redirect("/note/$params[id]", true);
    }
}