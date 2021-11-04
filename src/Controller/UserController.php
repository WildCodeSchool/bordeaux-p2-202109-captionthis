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
            $userId = $userManager->create($_POST);
            $userData = $userManager->selectOneById($userId);
            $_SESSION['user'] = $userData;
            header('Location: /profil?id=' . $userId);
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
                var_dump('échec de la connexion');
            };
            header('Location:/');
        }
        return $this->twig->render('User/connect.html.twig', [
        'session' => $_SESSION,
        ]);
    }
    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
    public function profile(int $id): string
    {
        $userManager = new UserManager();
        $userData = $userManager -> selectOneById($id);
        return $this->twig->render('User/profile.html.twig', [
            'user_data' => $userData,
            ]);
    }
}
