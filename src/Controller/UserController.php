<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{

    public function register(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $userManager->create($_POST);
            header('Location: /registration?register=true');
        }
        return $this->twig->render('User/register.html.twig', [
            'register_success' => $_GET['register'] ?? null,
        ]);
    }

    public function connect(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $userData = $userManager->selectOnebyName($_POST['name']);
            if (password_verify($_POST['password'], $userData['password'])) {
                $_SESSION['user'] = $userData;
            } else {
                var_dump('not ok');
            }
        }
        var_dump($_SESSION);
        return $this->twig->render('User/connect.html.twig');
    }
}
