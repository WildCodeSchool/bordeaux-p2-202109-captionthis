<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{

    public function register(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = (trim($_POST['name']));
            $nicknameGithub = (trim($_POST['nickname_github']));
            $password = ($_POST['password']);

            if (empty($name)) {
                $errors['name'] = 'Merci de rentrer votre nom';
            }
            if (empty($nicknameGithub)) {
                $errors['nickname_github'] = 'Merci de rentrer votre pseudo Github';
            }
            if (empty($password)) {
                $errors['password'] = 'Merci de rentrer votre pseudo mot de passe';
            }
            if (count($errors) === 0) {
                $userManager = new UserManager();
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $userId = $userManager->create($_POST);
                $userData = $userManager->selectOneById($userId);
                $_SESSION['user'] = $userData;
                header('Location: /profil?id=' . $userId);
            }
        }
        return $this->twig->render('User/register.html.twig', [
            'register_success' => $_GET['register'] ?? null,
            'errors'           => $errors
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
