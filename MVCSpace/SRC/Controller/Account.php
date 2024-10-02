<?php

declare(strict_types=1);

namespace MVCSpace\Controller;

use MVCSpace\Core\App;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IDelete;
use MVCSpace\Core\Interface\Controller\IGet;
use MVCSpace\Core\Interface\Controller\IPut;
use MVCSpace\Core\Service\Container;
use MVCSpace\Core\Service\Services\SessionManager;
use MVCSpace\Core\Utils\InputValidator;

class Account implements IGet, IDelete, IPut
{
    private SessionManager $sm;

    public function __construct()
    {
        $this->sm = Container::getInstance()->get('sm');
    }

    public function getAction(Request $request, Response $response, array $params): void
    {
        $response->specifyContent(App::render('account',
            [
                'title' => 'Account Overview',
                'username' => $this->sm->get('username'),
                'email' => $this->sm->get('email'),
            ]));
    }

    public function deleteAction(Request $request, Response $response, array $params): void
    {
        $accountModel = new \MVCSpace\Model\Account();

        $accountModel->delete($this->sm->get('id'));

        $response->redirect('/logout', true);
    }

    public function putAction(Request $request, Response $response, array $params): void
    {
        extract($request->getPayload());

        $accountModel = new \MVCSpace\Model\Account();

        if ($email !== '') {
            if (!InputValidator::invalidEmail($email) && !$accountModel->findMail($email)) {
                $accountModel->updateMail($this->sm->get('id'), $email);
                $this->sm->set('email', $email);
            }
        }

        if ($newpw !== '') {
            if (!InputValidator::invalidPassword($newpw)) {
                $accountModel->updatePassword($this->sm->get('id'), $newpw);
            }
        }

        $response->redirect('/account', true);
    }
}