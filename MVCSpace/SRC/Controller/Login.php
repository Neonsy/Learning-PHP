<?php

declare(strict_types=1);

namespace MVCSpace\Controller;

use MVCSpace\Core\App;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IGet;
use MVCSpace\Core\Interface\Controller\IPost;
use MVCSpace\Core\Service\Container;
use MVCSpace\Core\Service\Services\SessionManager;
use MVCSpace\Core\Utils\InputValidator;

class Login implements IGet, IPost
{

    public function getAction(Request $request, Response $response, array $params): void
    {
        $response->specifyContent(App::render('login',
            [
                'title' => 'Login',
            ]));
    }

    public function postAction(Request $request, Response $response, array $params): void
    {
        extract($request->getPayload());

        $accountModel = new \MVCSpace\Model\Account();

        $id = $accountModel->matchCredentials($email, $password);
        if ($id) {
            /** @var SessionManager $sm */
            $sm = Container::getInstance()->get('sm');
            $sm->set('id', $id);
            $sm->set('email', $email);

            $userName = $accountModel->findMail($email)['username'];
            $sm->set('username', $userName);

            $response->redirect('/notes');
        } else {
            $response->redirect('/login');
        }
    }
}