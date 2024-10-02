<?php

declare(strict_types=1);

namespace MVCSpace\Controller;

use MVCSpace\Core\App;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IGet;
use MVCSpace\Core\Interface\Controller\IPost;
use MVCSpace\Core\Utils\InputValidator;

class Register implements IGet, IPost
{

    public function getAction(Request $request, Response $response, array $params): void
    {
        $response->specifyContent(App::render('register',
            [
                'title' => 'Register',
            ]));
    }

    public function postAction(Request $request, Response $response, array $params): void
    {
        extract($request->getPayload());

        // Check username
        if (InputValidator::invalidUsername($username)) {
            $response->redirect('/register');
        }

        // Check email
        if (InputValidator::invalidEmail($email)) {
            $response->redirect('/register');
        }

        // Check password
        if (InputValidator::invalidPassword($password)) {
            $response->redirect('/register');
        }

        $accountModel = new \MVCSpace\Model\Account();

        if ($accountModel->findName($username) || $accountModel->findMail($email)) {
            $response->redirect('/register');
        }

        $accountModel->create($username, $email, $password);

        $response->redirect('/login');
    }
}